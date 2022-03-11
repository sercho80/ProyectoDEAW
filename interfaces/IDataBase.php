<?php
interface IDatabase
{
    public function conectar();
    public function desconectar();
    public function ejecutarSql(string $sql);
    public function ejecutarSqlActualizacion(string $sql, array $args);
}
