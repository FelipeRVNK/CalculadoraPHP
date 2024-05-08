<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>

    <link rel="stylesheet" href="style.css">

    <?php

    session_start();

    $nr1 = 0;
    $nr2 = 0;
    $resultado = 0;
    $calcular = 0;

    function fatoracao($num){
        $fatores = array();
        for ($i = 2; $i <= $num; $i++) {
            while ($num % $i == 0) {
                $fatores[] = $i;
                $num /= $i;
            }
        }
        return $fatores;
    }

    if (!isset($_SESSION['historico'])) {
        $_SESSION['historico'] = array();
    }

    if (!isset($_SESSION['memoria'])) {
        $_SESSION['memoria'] = array('nr1' => 0, 'nr2' => 0, 'calcular' => 'somar');
    }

    if (isset($_GET['nr1'], $_GET['nr2'], $_GET['calcular'])) {
        $nr1 = $_GET['nr1'];
        $nr2 = $_GET['nr2'];
        $calcular = $_GET['calcular'];

        switch ($calcular) {
            case 'somar':
                $resultado = $nr1 + $nr2;
                break;
            case 'subtrair':
                $resultado = $nr1 - $nr2;
                break;
            case 'multiplicar':
                $resultado = $nr1 * $nr2;
                break;
            case 'dividir':
                $resultado = $nr1 / $nr2;
                break;
            case 'fatorar':
                $resultado = fatoracao($nr1);
                break;
            case 'potencia':
                $resultado = pow($nr1, $nr2);
                break;
        }

        $_SESSION['historico'][] = array(
            'nr1' => $nr1,
            'nr2' => $nr2,
            'calcular' => $calcular,
            'resultado' => $resultado
        );
    }

    if (isset($_GET['limpar_historico'])) {
        $_SESSION['historico'] = array();
    }

    if (isset($_GET['memoria'])) {
        $_SESSION['memoria'] = array('nr1' => $nr1, 'nr2' => $nr2, 'calcular' => $calcular);
    }

    ?>



</head>

<body>
    <form>

        <h1>Calculadora PHP</h1>

        <div class="infoCalc">
            Primeiro número:
            <input type="number" required name="nr1" value=<?php echo $nr1; ?> /> 
            <select name="calcular">
                <option value="somar" <?php echo ($calcular == 'somar') ? 'selected' : ''; ?>>Somar</option>
                <option value="subtrair" <?php echo ($calcular == 'subtrair') ? 'selected' : ''; ?>>Subtrair</option>
                <option value="multiplicar" <?php echo ($calcular == 'multiplicar') ? 'selected' : ''; ?>>Multiplicar
                </option>
                <option value="dividir" <?php echo ($calcular == 'dividir') ? 'selected' : ''; ?>>Dividir</option>
                <option value="fatorar" <?php echo ($calcular == 'fatorar') ? 'selected' : ''; ?>>Fatorar</option>
                <option value="potencia" <?php echo ($calcular == 'potencia') ? 'selected' : ''; ?>>Potência</option>
            </select>
            Segundo número:
            <input type="number" required name="nr2" value=<?php echo $nr2; ?> />
        </div>
        <br>
        <br>

        <input type="submit" class="botao-calcular" value="calcular" />

        <input type="submit" class="botao-calcular" name="limpar_historico" value="Limpar Histórico" />

        <input type="submit" class="botao-calcular" name="memoria" value="M" />



    </form>


    <h2>Histórico</h2>
    <table>
        <tr>
            <th>Numero 1</th>
            <th>Numero 2</th>
            <th>Operacao</th>
            <th>Resultado</th>
        </tr>
        <?php foreach ($_SESSION['historico'] as $operação) : ?>
        <tr>
            <td><?php echo $operação['nr1']; ?></td>
            <td><?php echo $operação['nr2']; ?></td>
            <td><?php echo $operação['calcular']; ?></td>
            <td><?php echo is_array($operação['resultado']) ? implode(', ', $operação['resultado']) : $operação['resultado']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>