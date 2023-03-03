<?php
// Скрипт реализации логики приложения

// подключаем все классы
require_once('Graph.php');
require_once('Dijkstra.php');
require_once('Service.php');

// Основная логика

// тестовая матрица
// $matrix = Service::genTestMatrix();

// генерируем/получаем матрицу
$matrix = Service::getMatrix();

// получаем актуальные размеры матрицы POST
$size = Service::getSize();

// создаем граф по матрице
$graph = new Graph($matrix);

// пустой массив результатов
$result = [];

// получаем координаты первой и второй точки
$coordinates = Service::getCoordinates();

// если есть координаты первой и второй точки
if($coordinates['begin'] && $coordinates['end']){
	// создаем эксземпляр реализации алгоритм Дейкстры
	$dijkstra = new Dijkstra($graph);

	// получаем итоговую информацию о найденом или не найденом пути
	$result = $dijkstra->getResult($coordinates['begin'], $coordinates['end']);
}

// фикс ширины блока матрицы
$fullWidth = count($matrix) > 11 ? 'width' : '';