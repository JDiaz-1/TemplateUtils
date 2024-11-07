<?php

namespace Agrocolor\TemplateUtils;

use InvalidArgumentException;

class TemplateUtils
{
    /**
     * Renderiza un HTML con directivas PHP.
     *
     * @param string $html El contenido del HTML con directivas PHP.
     * @param array $data Variables que serán reemplazadas en el HTML.
     * @return string El HTML renderizado.
     * @throws Exception Si ocurre algún error durante el procesamiento del HTML.
     */
    public static function renderHtml(string $html, array $data): string
    {
        // Iniciamos el buffer de salida
        ob_start();


        // Extraemos las variables del array para que estén disponibles en el scope local
        extract($data, EXTR_SKIP);

        // Evaluamos el contenido de la plantilla
        try {
            // Procesamos el contenido de la plantilla directamente con las variables extraídas
            eval('?>' . $html);
        } catch (\Throwable $e) {
            // Limpiamos el buffer y lanzamos la excepción si hay un error
            ob_end_clean();
            throw new \Exception('Error al procesar la plantilla: ' . $e->getMessage());
        }

        // Obtenemos el contenido generado
        $renderedContent = ob_get_clean();

        return $renderedContent;
    }
}

