<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Usuario;

final class UsuarioTest extends TestCase {

    public function testDeveCriarUsuarioComDadosValidos(): void {

        $senhaHash = password_hash('123456', PASSWORD_DEFAULT);
        $usuario = new Usuario (
            null,
            'Administrador',
            'admin@email.com',
            $senhaHash,
            'admin',
            '2026-04-08 11:50:05'
        );

        $this->assertSame('Administrador', $usuario->getNome());
        $this->assertSame('admin@email.com', $usuario->getEmail());
        $this->assertSame($senhaHash, $usuario->getSenhaHash());
        $this->assertSame('admin', $usuario->getPerfil());
    }

    public function testDeveLancarExcecaoQuandoEmailForInvalido(): void {

        $this->expectException(\InvalidArgumentException::class);
        $senhaHash = password_hash('123456', PASSWORD_DEFAULT);
        new Usuario(
            null,
            'Administrador',
            'adminemail.com',
            $senhaHash,
            'admin',
            '2026-04-08 11:50:05'
        );

    }

    public function testDeveLancarExcecaoQuandoPerfilForInvalido(): void {
        $this->expectException(\InvalidArgumentException::class);
        $senhaHash = password_hash('123456', PASSWORD_DEFAULT);
        new Usuario(
            null,
            'Administrador',
            'admin@email.com',
            $senhaHash,
            '',
            '2026-04-08 11:50:05'
        );
    }
}