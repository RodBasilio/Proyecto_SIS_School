<?php

use PHPUnit\Framework\TestCase;

class ConductaTest extends TestCase{

    private $conducta;
    public function setup(): void
    {
        $this->conducta = new Conducta();
    }

    public function testInsertar(): void
    {
        $kind_id = 1;
        $date_at = '2023-10-31';
        $alumn_id = 1;
        $team_id = 1;
        $comments = 'Prueba de comentarios';

        $result = $this->conducta->insertar($kind_id, $date_at, $alumn_id, $team_id, $comments);

        $this->assertTrue($result, 'Error al insertar conducta');
    }

    public function testEditar(): void
    {
        $id = 1;
        $kind_id = 2;
        $date_at = '2023-11-01';
        $alumn_id = 1;
        $team_id = 1;
        $comments = 'Prueba de comentarios editados';

        $result = $this->conducta->editar($id, $kind_id, $date_at, $alumn_id, $team_id, $comments);

        $this->assertTrue($result, 'Error al editar conducta');
    }
}


?>