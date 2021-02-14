<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categoria;
use App\Repository\RepositoryCategoria;
use App\Entity\Producto;
use App\Repository\RepositoryProducto;
use App\Entity\Pedido;
use App\Repository\RepositoryPedido;
use App\Entity\PedidoProducto;
use App\Repository\RepositoryPedidoProducto;
use App\Entity\Restaurante;
use App\Repository\RepositoryRestaurante;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Message;

class PedidosBaseController extends AbstractController
{
    /**
     * @Route("/pedidos/base", name="pedidos_base")
     */
    public function index(): Response
    {
        return $this->render('pedidos_base/index.html.twig', [
            'controller_name' => 'PedidosBaseController',
        ]);
    }

    /**
    * @Route("/categorias/{id}", name="categorias")
    */
    public function mostrarCategorias($id) {
        $categorias = $this->getDoctrine()
            ->getRepository(Restaurante::class)
            ->find($id)
            ->getCategoria();
            if (!$categorias) {
                throw $this->createNotFoundException('Categoría no encontrada');
            }
        return $this->render("categoria/index.html.twig", array('categorias'=>$categorias));
    }

        /**
        * @Route("/productos/{id}", name="productos")
        */
        public function mostrarProductos($id) {
            $productos = $this->getDoctrine()
            ->getRepository(Categoria::class)
            ->find($id) 
            ->getProductos();
            if (!$productos) {
                throw $this->createNotFoundException('Categoría no encontrada');
            }
            return $this->render("/producto/index.html.twig", array('productos'=> $productos));
        }

       /**
       * @Route("/carrito", name="carrito")
       */
        public function mostrarCarrito(SessionInterface $session){
            /* para cada elemento del carrito se consulta la base de datos y se
            recuperan sus datos*/
            $productos = [];
            $carrito = $session->get('carrito');
            /* si el carrito no existe se crea como un array vacío*/
            if(is_null($carrito)){
                $carrito = array();
                $session->set('carrito', $carrito);
            }
            /* se crea array con todos los datos de los productos y la cantidad*/
            foreach ($carrito as $codigo => $cantidad){
                $producto = $this->getDoctrine()
                ->getRepository(Producto::class)
                ->find((int)$codigo);
                $elem = [];
                $elem['codProd'] = $producto->getCodProd();
                $elem['nombre'] = $producto->getNombre();
                $elem['peso'] = $producto->getPeso();
                $elem['stock'] = $producto->getStock();
                $elem['descripcion'] = $producto->getDescripcion();
                $elem['unidades'] = implode($cantidad);
                $productos[] = $elem;
            }
            return $this->render("carrito.html.twig",
            array('productos'=>$productos));
        }

        /**
         * @Route("/anadir", name="anadir")
         */
        public function anadir(SessionInterface $session) {
            $id = $_POST['cod'];
            $unidades= $_POST['unidades'];
            $carrito = $session->get('carrito');
            if(is_null($carrito)){
                $carrito = array();
            }
            if(isset($carrito[$id])){
                $carrito[$id]['unidades'] += intval($unidades);
            }else{
                $carrito[$id]['unidades'] = intval($unidades);
            }
            $session->set('carrito', $carrito);
            return $this->redirectToRoute('carrito');
        }
        /**
         * * @Route("/eliminar", name="eliminar")
        */
        public function eliminar(SessionInterface $session){
            $id = $_POST['cod'];
            $unidades= $_POST['unidades'];
            $carrito = $session->get('carrito');
            if(is_null($carrito)){
                $carrito = array();
            }
            if(isset($carrito[$id])){
                $carrito[$id]['unidades'] -= intval($unidades);
                if($carrito[$id]['unidades'] <= 0) {
                    unset($carrito[$id]);
                }
            }
            $session->set('carrito', $carrito);
            return $this->redirectToRoute('carrito');
        }

        /**
        * @Route("/realizarPedido", name="realizarPedido")
        *
        */
        public function realizarPedido(SessionInterface $session, \Swift_Mailer $mailer) {
            $entityManager = $this->getDoctrine()->getManager();
            $carrito = $session->get('carrito');
            /* si el carrito no existe, o está vacío*/
            if(is_null($carrito) ||count($carrito)==0){
                return $this->render("/pedido/index.html.twig", array('error'=>1));
            }else{
                #crear un nuevo pedido
                $pedido = new Pedido();
                $pedido->setFecha(new \DateTime());
                $pedido->setEnviado(0);
                $entityManager->persist($pedido);
                #recorrer carrito creando nuevos pedidoproducto
                foreach ($carrito as $codigo => $cantidad){
                    $producto = $this->getDoctrine()
                    ->getRepository(Producto::class)
                    ->find($codigo);
                    $fila = new PedidoProducto();
                    $fila->setCodProd($producto);
                    $fila->setUnidades( implode($cantidad));
                    $fila->setCodPed($pedido);
                    //actualizar el stock
                    $cantidad = implode($cantidad);
                    $query = $entityManager->createQuery(
                    "UPDATE App\Entity\Producto p
                    SET p.stock = p.stock - $cantidad
                    WHERE p.codProd = $codigo");
                    $resul = $query->getResult();
                    $entityManager->persist($fila);
                }
            }
            /*si hay error con la BD,
            Muestra plantilla con el código adecuado*/
            try{
                $entityManager->flush();
            }catch (Exception $e) {
                return $this->render("pedido.html.twig",
                array( 'error'=>2));
            }
            /*prepara el array de productos para la plantilla*/
            foreach ($carrito as $codigo => $cantidad){
                $producto = $this->getDoctrine()
                    ->getRepository(Producto::class)
                    ->find((int)$codigo);
                $elem = [];
                $elem['codProd'] = $producto->getCodProd();
                $elem['nombre'] = $producto->getNombre();
                $elem['peso'] = $producto->getPeso();
                $elem['stock'] = $producto->getStock();
                $elem['descripcion'] = $producto->getDescripcion();
                $elem['unidades'] = implode($cantidad);
                $productos[] = $elem;
            }
            //vaciar el carrito
            $session->set('carrito', array());
            /* mandar el correo */

            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 25, 'tls'))
                        ->setUsername('noreply.empresafalsa@gmail.com')
                        ->setPassword('Empresa_1')
                        ->setStreamOptions(array('ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )));
            $mailer = new Swift_Mailer($transport);   
            $message = (new \Swift_Message())
            ->setFrom('noreply.empresafalsa@gmail.com', 'Sistema de pedidos')
            ->setTo($this->getUser()->getEmail())
            ->setSubject("Pedido ". $pedido->getCodPed(). " confirmado")
            ->setBody($this->renderView('correo.html.twig',
                array('codPed'=>$pedido->getCodPed(),
                'productos'=> $productos)),
                'text/html');
            $mailer->send($message);
            return $this->render("/pedido/index.html.twig", array('error'=>0,'codPed'=>$pedido->getCodPed(),
            'productos'=> $productos));
        }
}
