<?php

/**
 * Класс статических функций, реализующий логику приложения
 * Class Service
 */
class Service
{
    /**
     * Кодируем координаты одной точки с раздилителем "_"
     * @param array $array
     * @return string
     */
    public static function encodeCoordinats(array $array): string
	{
		return implode('_', $array);
	}

    /**
     * Декодируем координаты одной точки с раздилителем "_"
     * @param string $str
     * @return array
     */
    public static function decodeCoordinats(string $str): array
	{
		return explode('_', $str);
	}

    /**
     * Проверяем присутствуют ли координаты точки $search в $array
     * @param array $array
     * @param array $search
     * @return bool
     */
    public static function inArray(array $array, array $search): bool
	{
		foreach($array as $item)
		{
			$cord = self::decodeCoordinats($item);
			
			if($cord == $search)
			{
				return true;
			}
		}
		return false;
	}

    /**
     * Функция генерации матрицы
     * @param int $n
     * @param int $m
     * @return array
     */
    public static function genMatrix(int $n = 10, int $m = 10): array
	{
		$n = (int)$n;
		$m = (int)$m;
		
		// $n и $m должны быть в пределах от 2 до 30
		// это связано с ограничением на передачу данных в форме у одного поля в 1000
		// число 30 выбрано как оптимальное круглое
		// хотя по факту больше 24х24 уже смотрится не очень красиво
		if($n < 2 || $n > 30)
		{
			$n = 10;
		}
		if($m < 2 || $m > 30)
		{
			$m = 10;
		}
		
		$matrix = [];
		for($i = 0; $i < $n; $i++)
		{
			for($j = 0; $j < $m; $j++)
			{
				$matrix[$i][$j] = rand(0, 9);
			}
		}
		
		return $matrix;
	}

    /**
     * Функция получения POST значений
     * @param $key
     * @return false|mixed|null
     */
    public static function getRequest($key)
	{
		if (!is_array($_REQUEST))
		{
			return false;
		}

		if ($key === false)
		{
			return null;
		}

		if (array_key_exists($key, $_REQUEST))
		{
			return $_REQUEST[$key];
		}

		return null;
	}

    /**
     * Получает json и проверяет его на корректность
     * @return array
     */
    public static function getJson(): array
	{
		$json = self::getRequest('json');
		$decode = json_decode($json, true);
		if($decode !== null)
		{
			if(self::checkMatrix($decode))
			{
				return $decode;
			}
		}
		return [];
	}

    /**
     * Получаем матрицу
     * @return array
     */
    public static function getMatrix(): array
	{
		$matrix = self::getRequest('matrix');
		$size = self::getSize();
		$generate = self::generate();
		$json = self::getJson();
		
		// если матрица не передана или передан режим генерации
		if(!$matrix || $generate)
		{
			// если 2 то из json
			if($generate === 2){
				if($json){
					// если json корректный и соотвествует условиям
					$matrix = $json;
				}else{
					// иначе генерируем рандомную по умолчанию
					$matrix = self::genMatrix($size[0], $size[1]);
				}
			}else{
				$matrix = self::genMatrix($size[0], $size[1]);	
			}
		}else{
			// если по каким то причинам не проходит проверку
			if(!self::checkMatrix($matrix))
			{
				$matrix = self::genMatrix($size[0], $size[1]);
			}
		}
		
		return $matrix;
	}

    /**
     * Координаты начальной и конечной точки
     * @return array|null
     */
    public static function getCoordinates(): ?array
	{
		$begin = self::getRequest('begin') ?: '';
		$end = self::getRequest('end') ?: '';
		return [
			'begin' => $begin, 
			'end' => $end
		];
	}

    /**
     * Возвращаем размеры
     * @return array|int[]|null
     */
    public static function getSize(): ?array
	{
		$size = self::getRequest('size') ?: [];
		if(!self::checkSize($size))
		{
			return [10, 10];
		}
		return $size;
	}

    /**
     * Режим генерации
     * @return int
     */
    public static function generate(): int
	{
		return (int) self::getRequest('generate');
	}

    /**
     * Проверка переданных размеров
     * @param array $size
     * @return bool
     */
    public static function checkSize(array $size = []): bool
	{
		if(!isset($size[0]) && !isset($size[1]))
		{
			return false;
		}
		
		if($size[0] < 2 && $size[0] > 30)
		{
			return false;
		}
		if($size[1] < 2 && $size[1] > 30)
		{
			return false;
		}
			
		return true;
	}

    /**
     * Функция проверки матрицы на корректность
     * @param array $matrix
     * @return bool
     */
    public static function checkMatrix(array $matrix = []): bool
	{
		$n = 0;
		$m = 0;
		
		if(empty($matrix)) return false;
		
		foreach($matrix as $a)
		{
			$n++;
			if(!is_array($a))
			{
				return false;
			}
			
			foreach($a as $b)
			{
				$m++;
			}
			
			if($m < 2)
			{
				return false;
			}
		}
		
		if($n < 2)
		{
			return false;
		}
		
		return true;
	}

    /**
     * Тестовая матрица json в формате
     * @return string
     */
    public static function genTestMatrixJson(): string
	{
		return json_encode(self::genTestMatrix());
	}

    /**
     * Генерация тестовой матрицы
     * @return array[]
     */
    public static function genTestMatrix(): array
	{
		return Array
		(
			0 => Array
			(
				0 => 9,
				1 => 5,
				2 => 9,
				3 => 6,
				4 => 9,
				5 => 7,
				6 => 3,
				7 => 5,
				8 => 4,
				9 => 1,
			),

			1 => Array
			(
				0 => 0,
				1 => 4,
				2 => 8,
				3 => 7,
				4 => 0,
				5 => 4,
				6 => 0,
				7 => 2,
				8 => 5,
				9 => 3,
			),

			2 => Array
			(
				0 => 3,
				1 => 7,
				2 => 8,
				3 => 0,
				4 => 1,
				5 => 9,
				6 => 6,
				7 => 4,
				8 => 9,
				9 => 8,
			),

			3 => Array
			(
				0 => 8,
				1 => 4,
				2 => 9,
				3 => 1,
				4 => 3,
				5 => 1,
				6 => 0,
				7 => 9,
				8 => 4,
				9 => 0,
			),

			4 => Array
			(
				0 => 2,
				1 => 8,
				2 => 8,
				3 => 6,
				4 => 5,
				5 => 2,
				6 => 9,
				7 => 2,
				8 => 2,
				9 => 8,
			),

			5 => Array
			(
				0 => 4,
				1 => 2,
				2 => 1,
				3 => 7,
				4 => 1,
				5 => 6,
				6 => 6,
				7 => 3,
				8 => 6,
				9 => 5,
			),

			6 => Array
			(
				0 => 7,
				1 => 6,
				2 => 5,
				3 => 1,
				4 => 5,
				5 => 6,
				6 => 3,
				7 => 0,
				8 => 7,
				9 => 3,
			),

			7 => Array
			(
				0 => 8,
				1 => 2,
				2 => 8,
				3 => 6,
				4 => 8,
				5 => 7,
				6 => 2,
				7 => 2,
				8 => 8,
				9 => 6,
			),

			8 => Array
			(
				0 => 7,
				1 => 3,
				2 => 9,
				3 => 0,
				4 => 4,
				5 => 0,
				6 => 2,
				7 => 1,
				8 => 0,
				9 => 1,
			),

			9 => Array
			(
				0 => 3,
				1 => 0,
				2 => 6,
				3 => 4,
				4 => 4,
				5 => 3,
				6 => 3,
				7 => 7,
				8 => 6,
				9 => 2,
			)
		);
	}
}