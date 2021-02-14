<?php

namespace App\Controller;

use App\Entity\PedidoProducto;
use App\Form\PedidoProductoType;
use App\Repository\PedidoProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pedido/producto")
 */
class PedidoProductoController extends AbstractController
{
    /**
     * @Route("/", name="pedido_producto_index", methods={"GET"})
     */
    public function index(PedidoProductoRepository $pedidoProductoRepository): Response
    {
        return $this->render('pedido_producto/index.html.twig', [
            'pedido_productos' => $pedidoProductoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pedido_producto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pedidoProducto = new PedidoProducto();
        $form = $this->createForm(PedidoProductoType::class, $pedidoProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pedidoProducto);
            $entityManager->flush();

            return $this->redirectToRoute('pedido_producto_index');
        }

        return $this->render('pedido_producto/new.html.twig', [
            'pedido_producto' => $pedidoProducto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codPedProd}", name="pedido_producto_show", methods={"GET"})
     */
    public function show(PedidoProducto $pedidoProducto): Response
    {
        return $this->render('pedido_producto/show.html.twig', [
            'pedido_producto' => $pedidoProducto,
        ]);
    }

    /**
     * @Route("/{codPedProd}/edit", name="pedido_producto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PedidoProducto $pedidoProducto): Response
    {
        $form = $this->createForm(PedidoProductoType::class, $pedidoProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pedido_producto_index');
        }

        return $this->render('pedido_producto/edit.html.twig', [
            'pedido_producto' => $pedidoProducto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codPedProd}", name="pedido_producto_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PedidoProducto $pedidoProducto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pedidoProducto->getCodPedProd(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pedidoProducto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pedido_producto_index');
    }
}
