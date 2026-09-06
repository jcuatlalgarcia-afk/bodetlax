<?php

namespace App\Libraries;

class Notificador
{
    public function enviar(string $para, string $asunto, string $mensajeHtml): bool
    {
        $email = \Config\Services::email();
        $email->setTo($para);
        $email->setSubject($asunto);
        $email->setMessage($mensajeHtml);

        $enviado = $email->send();

        if (! $enviado) {
            log_message('error', 'Error de correo: ' . $email->printDebugger(['headers']));
        }

        return $enviado;
    }

    public function ofertaRevisada(string $paraEmail, string $nombreProveedor, string $nombreProducto, string $estado): bool
    {
        $mensaje = $estado === 'aceptada'
            ? "¡Buenas noticias, {$nombreProveedor}! Tu oferta para <strong>{$nombreProducto}</strong> fue aceptada. El negocio se pondrá en contacto contigo para coordinar la entrega."
            : "Hola {$nombreProveedor}, tu oferta para <strong>{$nombreProducto}</strong> fue rechazada en esta ocasión. Puedes enviar nuevas ofertas cuando gustes.";

        return $this->enviar($paraEmail, 'BodeTlax - Actualización de tu oferta', $mensaje);
    }

    public function vendedorAprobado(string $paraEmail, string $nombre): bool
    {
        $mensaje = "Hola {$nombre}, tu cuenta de vendedor en BodeTlax fue aprobada. Ya puedes iniciar sesión y comenzar a administrar el catálogo.";
        return $this->enviar($paraEmail, 'BodeTlax - Cuenta de vendedor aprobada', $mensaje);
    }

    public function vendedorRechazado(string $paraEmail, string $nombre): bool
    {
        $mensaje = "Hola {$nombre}, tu solicitud de cuenta de vendedor en BodeTlax no fue aprobada. Si crees que esto es un error, contacta al administrador.";
        return $this->enviar($paraEmail, 'BodeTlax - Solicitud de vendedor', $mensaje);
    }

    public function pedidoConfirmado(string $paraEmail, string $nombreCliente, int $pedidoId, float $total): bool
    {
        $mensaje = "Hola {$nombreCliente}, tu pedido #{$pedidoId} fue registrado con éxito. Total: $" . number_format($total, 2) . ". Puedes ver el seguimiento en tu cuenta.";
        return $this->enviar($paraEmail, 'BodeTlax - Pedido confirmado #' . $pedidoId, $mensaje);
    }

    public function nuevaOfertaParaAdmin(string $paraEmail, string $nombreProveedor, string $nombreProducto): bool
    {
        $mensaje = "El proveedor {$nombreProveedor} envió una nueva oferta: <strong>{$nombreProducto}</strong>. Revísala en el panel de administración.";
        return $this->enviar($paraEmail, 'BodeTlax - Nueva oferta de proveedor', $mensaje);
    }
}