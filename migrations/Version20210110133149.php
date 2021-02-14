<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110133149 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (codCat INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(200) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E10122D3A909126 ON categoria (nombre)');
        $this->addSql('CREATE TABLE pedido (codPed INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fecha DATETIME NOT NULL, enviado INTEGER NOT NULL, Restaurante INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_C4EC16CEDFCB4DA2 ON pedido (Restaurante)');
        $this->addSql('CREATE TABLE pedido_producto (cod_ped_prod INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, unidades INTEGER NOT NULL, Pedido INTEGER DEFAULT NULL, Producto INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_DD333C2C34013F8 ON pedido_producto (Pedido)');
        $this->addSql('CREATE INDEX IDX_DD333C25ECD6443 ON pedido_producto (Producto)');
        $this->addSql('CREATE TABLE producto (codProd INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(90) NOT NULL, peso DOUBLE PRECISION NOT NULL, stock INTEGER NOT NULL, Categoria INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_A7BB0615CCE1908E ON producto (Categoria)');
        $this->addSql('CREATE TABLE restaurante (codRes INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, correo VARCHAR(90) NOT NULL, clave VARCHAR(45) NOT NULL, pais VARCHAR(45) NOT NULL, cp INTEGER NOT NULL, ciudad VARCHAR(45) NOT NULL, direccion VARCHAR(200) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5957C27577040BC9 ON restaurante (correo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE restaurante');
    }
}
