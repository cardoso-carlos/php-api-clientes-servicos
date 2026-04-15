<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;
use App\Models\Usuario;
use PDO;

class UsuarioRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function inserir(Usuario $usuario): int {
        $sql = 'INSERT INTO usuarios(nome, email, senha_hash, perfil, criado_em)
                VALUES(:nome, :email, :senha_hash, :perfil, :criado_em)';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':nome' => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':senha_hash' => $usuario->getSenhaHash(),
            ':perfil' => $usuario->getPerfil(),
            ':criado_em' => $usuario->getCriadoEm(),
        ]);

        return (int) $this->connection->lastInsertId();
    }

    public function buscarPorId(int $id): ?Usuario {
        $sql = 'SELECT id, nome, email, senha_hash, perfil, criado_em
                FROM usuarios
                WHERE id = :id';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id,]);

        $row = $stmt->fetch();

        if(!$row) {
            return null;
        }

        return new Usuario(
            (int) $row['id'],
            $row['nome'],
            $row['email'],
            $row['senha_hash'],
            $row['perfil'],
            $row['criado_em']
        );
    }

    public function listarTodos(): array {
        $sql = 'SELECT id, nome, email, senha_hash, perfil, criado_em
                FROM usuarios
                ORDER BY id DESC';

        $stmt = $this->connection->query($sql);
        $rows = $stmt->fetchAll();
        
        $usuarios = [];

        foreach($rows as $row) {
            $usuarios[] = new Usuario(
                (int) $row['id'],
                $row['nome'],
                $row['email'],
                $row['senha_hash'],
                $row['perfil'],
                $row['criado_em']    
            );
        }

        return $usuarios;
    }


    public function buscarPorEmail(string $email): ?Usuario {
        $sql = 'SELECT id, nome, email, senha_hash, perfil, criado_em
                FROM usuarios
                WHERE email = :email';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':email' => $email,]);

        $row = $stmt->fetch();

        if(!$row) {
            return null;
        }

        return new Usuario(
            (int) $row['id'],
            $row['nome'],
            $row['email'],
            $row['senha_hash'],
            $row['perfil'],
            $row['criado_em']
        );    
    }

    public function atualizar(Usuario $usuario): bool {
        $id = $usuario->getId();

        if($id === null || $id <= 0){
            throw new \InvalidArgumentException('O id do usuário é obrigatório para atualização.');
        }

        $sql = 'UPDATE usuarios
                SET nome = :nome,
                    email = :email,
                    senha_hash = :senha_hash,
                    perfil = :perfil
                WHERE id = :id';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nome' => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':senha_hash' => $usuario->getSenhaHash(),
            ':perfil' => $usuario->getPerfil(),
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deletar(int $id): bool {
        $sql = 'DELETE FROM usuarios WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
