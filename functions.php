<?php
/**
 * Date: 05.07.18
 * @author Isaenko Alexey <info@oiplug.com>
 */


function esc( $data ) {
	$data = strip_tags( $data ); //Убирает все теги из строки
	$data = htmlspecialchars( $data ); //преобразует специальные символы в HTML сущности

	return $data;
}

function pr( $data ) {
	echo '<pre>';
	print_r( $data );
	echo '</pre>';
}

function check_form() {
	//print_r( $_POST );

	$errors = array();

	// если осуществляется передача данных
    // глобальная переменная
	if ( ! empty( $_POST ) ) {
		$data = $_POST;

		$needle = array(
			'email'    => 'Не введен Email, либо он не корректный',
			'password' => 'Не введен пароль',
			'agree'    => 'Вам необходимо согласиться с условиями',
		);

		foreach ( $needle as $name => $value ) {

			// если значение переданной переменной пусто
			if ( ! ( ! empty( $data[ $name ] ) && ! empty( esc( $data[ $name ] ) ) ) ) {

				$errors[] = $needle[ $name ];
			}
		}

		if ( empty( $errors ) ) {

			// регистрируем пользователя
			$errors = array_merge( $errors, register( $data ) );
		}
	}

	return $errors;
}

function the_errors() {
	$errors = check_form();
	if ( ! empty( $errors ) ) {
		foreach ( $errors as $i => $error ) {
			$errors[ $i ] = '<li>' . $errors[ $i ] . '</li>';
		}
		$errors = '<ul class="errors">' . implode( '', $errors ) . '</ul>';
		echo $errors;
	}
}

/*
function register( $data ) {
	foreach ( $data as $key => $value ) {
		$data[ $key ] = esc( $data[ $key ] );
	}
	$errors = array();
	$users  = explode( "\n", file_get_contents( 'users.txt' ) );
	foreach ( $users as $user ) {
		$user = json_decode( $user, true );
		if ( $user['email'] == $data['email'] ) {
			$errors[] = 'Пользователь с указанным Email существует!';

			return $errors;
		}
	}

	file_put_contents( 'users.txt', json_encode( $data ) . "\n" );
	header( 'location: ?register=success' );
	fclose('user.txt');
}
*/
//Поочередно получаем строки и выводим в браузер
function readFile()
{
    $descriptor = fopen('users.txt', 'r');
    $p_str=array();
    if ($descriptor) {
        while (($string = fgets($descriptor))) {
            $p_str[]= $string;
        }
        fclose($descriptor);

    } else {
        echo 'Невозможно открыть указанный файл';
    }
    return $p_str;
}

/*
1. Дописать функцию esc
2. Написать функцию проверки введенного email'а
3. Решить примеры по булевой алгебре
4. Сделать чтение файла построчно
5. Использовать добавление данных в файл, дописывая его, а не переписывая, чтобы файл содержал данные нескольких пользователей

*/

// eof
