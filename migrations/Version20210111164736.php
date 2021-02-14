<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210111164736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4E10122D3A909126');
        $this->addSql('CREATE TEMPORARY TABLE __temp__categoria AS SELECT codCat, nombre, descripcion FROM categoria');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('CREATE TABLE categoria (codCat INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL COLLATE BINARY, descripcion VARCHAR(200) NOT NULL COLLATE BINARY, Restaurante INTEGER DEFAULT NULL, CONSTRAINT FK_4E10122DDFCB4DA2 FOREIGN KEY (Restaurante) REFERENCES restaurante (codRes) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO categoria (codCat, nombre, descripcion) SELECT codCat, nombre, descripcion FROM __temp__categoria');
        $this->addSql('DROP TABLE __temp__categoria');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E10122D3A909126 ON categoria (nombre)');
        $this->addSql('CREATE INDEX IDX_4E10122DDFCB4DA2 ON categoria (Restaurante)');
        $this->addSql('DROP INDEX IDX_C4EC16CEDFCB4DA2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido AS SELECT codPed, fecha, enviado, Restaurante FROM pedido');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('CREATE TABLE pedido (codPed INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fecha DATETIME NOT NULL, enviado INTEGER NOT NULL, Restaurante INTEGER DEFAULT NULL, CONSTRAINT FK_C4EC16CEDFCB4DA2 FOREIGN KEY (Restaurante) REFERENCES restaurante (codRes) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO pedido (codPed, fecha, enviado, Restaurante) SELECT codPed, fecha, enviado, Restaurante FROM __temp__pedido');
        $this->addSql('DROP TABLE __temp__pedido');
        $this->addSql('CREATE INDEX IDX_C4EC16CEDFCB4DA2 ON pedido (Restaurante)');
        $this->addSql('DROP INDEX IDX_DD333C2C34013F8');
        $this->addSql('DROP INDEX IDX_DD333C25ECD6443');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido_producto AS SELECT cod_ped_prod, unidades, Pedido, Producto FROM pedido_producto');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('CREATE TABLE pedido_producto (cod_ped_prod INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, unidades INTEGER NOT NULL, Pedido INTEGER DEFAULT NULL, Producto INTEGER DEFAULT NULL, CONSTRAINT FK_DD333C2C34013F8 FOREIGN KEY (Pedido) REFERENCES pedido (codPed) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DD333C25ECD6443 FOREIGN KEY (Producto) REFERENCES producto (codProd) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO pedido_producto (cod_ped_prod, unidades, Pedido, Producto) SELECT cod_ped_prod, unidades, Pedido, Producto FROM __temp__pedido_producto');
        $this->addSql('DROP TABLE __temp__pedido_producto');
        $this->addSql('CREATE INDEX IDX_DD333C2C34013F8 ON pedido_producto (Pedido)');
        $this->addSql('CREATE INDEX IDX_DD333C25ECD6443 ON pedido_producto (Producto)');
        $this->addSql('DROP INDEX IDX_A7BB0615CCE1908E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT codProd, nombre, descripcion, peso, stock, Categoria FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (codProd INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL COLLATE BINARY, descripcion VARCHAR(90) NOT NULL COLLATE BINARY, peso DOUBLE PRECISION NOT NULL, stock INTEGER NOT NULL, Categoria INTEGER DEFAULT NULL, CONSTRAINT FK_A7BB0615CCE1908E FOREIGN KEY (Categoria) REFERENCES categoria (codCat) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO producto (codProd, nombre, descripcion, peso, stock, Categoria) SELECT codProd, nombre, descripcion, peso, stock, Categoria FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB0615CCE1908E ON producto (Categoria)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4E10122D3A909126');
        $this->addSql('DROP INDEX IDX_4E10122DDFCB4DA2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__categoria AS SELECT codCat, nombre, descripcion FROM categoria');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('CREATE TABLE categoria (codCat INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(200) NOT NULL)');
        $this->addSql('INSERT INTO categoria (codCat, nombre, descripcion) SELECT codCat, nombre, descripcion FROM __temp__categoria');
        $this->addSql('DROP TABLE __temp__categoria');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E10122D3A909126 ON categoria (nombre)');
        $this->addSql('DROP INDEX IDX_C4EC16CEDFCB4DA2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido AS SELECT codPed, fecha, enviado, Restaurante FROM pedido');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('CREATE TABLE pedido (codPed INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fecha DATETIME NOT NULL, enviado INTEGER NOT NULL, Restaurante INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO pedido (codPed, fecha, enviado, Restaurante) SELECT codPed, fecha, enviado, Restaurante FROM __temp__pedido');
        $this->addSql('DROP TABLE __temp__pedido');
        $this->addSql('CREATE INDEX IDX_C4EC16CEDFCB4DA2 ON pedido (Restaurante)');
        $this->addSql('DROP INDEX IDX_DD333C2C34013F8');
        $this->addSql('DROP INDEX IDX_DD333C25ECD6443');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pedido_producto AS SELECT cod_ped_prod, unidades, Pedido, Producto FROM pedido_producto');
        $this->addSql('DROP TABLE pedido_producto');
        $this->addSql('CREATE TABLE pedido_producto (cod_ped_prod INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, unidades INTEGER NOT NULL, Pedido INTEGER DEFAULT NULL, Producto INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO pedido_producto (cod_ped_prod, unidades, Pedido, Producto) SELECT cod_ped_prod, unidades, Pedido, Producto FROM __temp__pedido_producto');
        $this->addSql('DROP TABLE __temp__pedido_producto');
        $this->addSql('CREATE INDEX IDX_DD333C2C34013F8 ON pedido_producto (Pedido)');
        $this->addSql('CREATE INDEX IDX_DD333C25ECD6443 ON pedido_producto (Producto)');
        $this->addSql('DROP INDEX IDX_A7BB0615CCE1908E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__producto AS SELECT codProd, nombre, descripcion, peso, stock, Categoria FROM producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('CREATE TABLE producto (codProd INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(45) NOT NULL, descripcion VARCHAR(90) NOT NULL, peso DOUBLE PRECISION NOT NULL, stock INTEGER NOT NULL, Categoria INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO producto (codProd, nombre, descripcion, peso, stock, Categoria) SELECT codProd, nombre, descripcion, peso, stock, Categoria FROM __temp__producto');
        $this->addSql('DROP TABLE __temp__producto');
        $this->addSql('CREATE INDEX IDX_A7BB0615CCE1908E ON producto (Categoria)');
    }
}
