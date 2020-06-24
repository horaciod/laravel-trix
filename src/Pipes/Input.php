<?php

namespace Te7aHoudini\LaravelTrix\Pipes;

use Te7aHoudini\LaravelTrix\LaravelTrix;

class Input
{
    public function handle(LaravelTrix $trix, \Closure $next)
    {
        $html = is_object($trix->model) && $trix->model->exists ? htmlspecialchars(optional($trix->model->trixRichText()->where('field', $trix->config['field'])->first())->content, ENT_QUOTES) : '';
        // in case of empty value  recover from model
        if ($html == '') {
            // recovery from model
            $field = $trix->config['field'];
            if ($trix->model->$field) {
                $html = $trix->model->$field ;
            }

        }
        $trix->html .= "<input id='{$trix->config['id']}' value='{$html}' name='{$trix->loweredModelName}-trixFields[{$trix->config['field']}]' type='hidden'>";

        return $next($trix);
    }
}
