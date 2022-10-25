<?php

declare(strict_types=1);
$data['titulo'] = "Calculos notas";
$data["div_titulo"] = "Formulario";

if (isset($_POST['enviar'])) {
    $data['errores'] = checkForm($_POST);
    $data['input'] = filter_var($_POST['json'], FILTER_SANITIZE_SPECIAL_CHARS);
    if (count($data['errores']) == 0) {
        $data['resultado'] =  modulosNotas(json_decode($_POST['json'], true));
        //var_dump($data['resultado']['asignaturas']);die;
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
                        if (empty($nombreAlumno)) {
                            $jsonErrores[] = "En la asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . " hay un alumno sin nombre";
                        }
                        if (!is_array($nota)) {
                            $jsonErrores[] = "Las notas de la asignatura " . $asignatura . " tienen que ser un array";
                        } else {

                            for ($i = 0; $i < count($nota); $i++) {
                                if (empty($nombreAlumno)) {
                                    $jsonErrores[] = "En la asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . " hay un alumno sin nombre";
                                }
                                if (!is_numeric($nota[$i])) {
                                    $jsonErrores[] = "La asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . " tiene una nota " . filter_var($nota, FILTER_SANITIZE_SPECIAL_CHARS) . " la cual no es un numero";
                                } else {
                                    if ($nota[$i] < 0 || $nota[$i] > 10) {
                                        $jsonErrores[] = "En la asignatura " . filter_var($asignatura, FILTER_SANITIZE_SPECIAL_CHARS) . ", alumno " . filter_var($nombreAlumno, FILTER_SANITIZE_SPECIAL_CHARS) . " tiene una nota de " . filter_var($nota[$i], FILTER_SANITIZE_SPECIAL_CHARS);
                                    }
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

    //var_dump($errores);
    return $errores;
}


function modulosNotas(array $arrayNotas)
{
    $resultado = [];
    $array = [];
    foreach ($arrayNotas as $asignatura => $notas) {

        $array[$asignatura] = [];

        $aprobados = 0;
        $suspensos = 0;

        $notaMax = [
            'alumno' => "",
            'nota' => -1

        ];

        $notaMin = [
            'alumno' => "",
            'nota' => 11

        ];

        $suma = 0;
        $cuenta = 0;
        $suspenso = false;
        $suspensos = 0;
        $aprobados = 0;
        $notaMaxAlumno = -1;
        $notaMinAlumno = 11;
        foreach ($notas as $alumno => $nota) {
            if (!isset($alumnos[$alumno])) {
                $alumnos[$alumno] = ['aprobados' => 0, 'suspensos' => 0];
            }


                 ////////// nota alumno///////////
            for ($i = 0; $i < count($nota); $i++) {
                $suma += $nota[$i];
                $cuenta++;

                if ($nota[$i] < 5) {
                    $suspenso = true;
                }

                if ($nota[$i] > $notaMaxAlumno) {
                    $notaMaxAlumno = $nota[$i];
                }

                if ($nota[$i] < $notaMinAlumno) {
                    $notaMinAlumno = $nota[$i];
                }
  
            }
                     //////////////////


            if ($notaMaxAlumno > $notaMax['nota']) {
                $notaMax['alumno'] = $alumno;
                $notaMax['nota'] = $notaMaxAlumno;
            }
            if ($notaMinAlumno < $notaMin['nota']) {
                $notaMin['alumno'] = $alumno;
                $notaMin['nota'] = $notaMinAlumno;
            }
            
            if ($suspenso) {
                $alumnos[$alumno]['suspensos']++;
                $suspensos++;
                $suspenso = false;
            } else {
                $alumnos[$alumno]['aprobados']++;
                $aprobados++;
            }
        }

        if ($cuenta > 0) {
            $resultado[$asignatura]['media'] = round($suma / $cuenta, 2);

            $resultado[$asignatura]['max'] = $notaMax;
            $resultado[$asignatura]['min'] = $notaMin;
        } else {
            $resultado[$asignatura]['media'] = 0;
        }
        $resultado[$asignatura]['suspensos'] = $suspensos;
        $resultado[$asignatura]['aprobados'] = $aprobados;
    }


    return array('asignaturas' => $resultado, 'alumnos' => $alumnos);
}


include 'views/templates/header.php';
include 'views/trabajoNotas.samuelBarros.view.php';
include 'views/templates/footer.php';
