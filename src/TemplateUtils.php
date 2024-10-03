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
        // Patrón para encontrar variables que comienzan con $
        $pattern = '/\$(\w+)/';

        // Reemplazamos las variables por $data['variable']
        $modifiedTemplate = preg_replace_callback($pattern, function ($matches) {
            $variableName = $matches[1];
            return "\$data['$variableName'] ?? null"; // Añadimos seguridad para variables inexistentes
        }, $html);

        // Iniciamos el buffer de salida
        ob_start();

        // Extraemos las variables del array para que estén disponibles en el scope local
        extract($data, EXTR_SKIP);

        // Evaluamos el contenido modificado de la plantilla
        try {
            eval('?>' . $modifiedTemplate);
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

