<?php

declare(strict_types=1);
$data['titulo'] = "Calculos notas";
$data["div_titulo"] = "Formulario";

if (isset($_POST['enviar'])) {
    $data['errores'] = checkForm($_POST);
    $data['input'] = filter_var($_POST['json'], FILTER_SANITIZE_SPECIAL_CHARS);
    if (count($data['errores']) == 0) {
        $data['resultado'] = [];
    }
}

function checkForm($post): array
{

    $errores = [];
    if (empty($post['json'])) {
        $errores['error'] = "El campo es obligatorio";
    } else {
        $asignaturas = json_decode($post['json'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errores['jsonError'] = "El formato del JSON es incorrecto";
        } else {
            $jsonErrores = [];

            foreach ($asignaturas as $asignatura => $alumnos) {
                if (empty($asignatura)) {
                    $jsonErrores[] = "La asignatura no puede estar vacia";
                }
                if (!is_array($alumnos)) {
                    $jsonErrores[] = "La asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . " no tiene un array de alumnos";
                } else {
                    foreach ($alumnos as $nombreAlumno => $nota) {
                        for ($i = 0; $i < count($nota); $i++) {
                            if (empty($nombreAlumno)) {
                                $jsonErrores[] = "En la asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . " hay un alumno sin nombre";
                            }
                            if (!is_numeric($nota[$i])) {
                                $jsonErrores[] = "La asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . " tiene una nota " . filter_var($nota, FILTER_SANITIZE_SPECIAL_CHARS) . " la cual no es un numero";
                            } else {
                                if ($nota[$i] < 0 || $nota[$i] > 10) {
                                    $jsonErrores[] = "En la asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . ", alumno " . filter_var($nombreAlumno, FILTER_SANITIZE_SPECIAL_CHARS) . " tiene una nota de " . filter_var($nota, FILTER_SANITIZE_SPECIAL_CHARS);
                                }
                            }
                        }
                    }
                }
            }
            if (count($jsonErrores) > 0) {
                $errores['error'] = $jsonErrores;
            }
        }
    }


    return $errores;
}


include 'views/templates/header.php';
include 'views/trabajoNotas.samuelBarros.view.php';
include 'views/templates/footer.php';
