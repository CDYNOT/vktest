<?php

/**
 * Класс графа
 * Class Graph
 */
class Graph
{
	/** @var array */
	private $edges; 
	
	public function __construct(array $fromArray = [])
	{
		$this->edges = [];
		$this->initToArray($fromArray);
	}
	
	// инициализирует граф из переданного массива
	public function initFromArray(array $fromArray = []): void
	{
		$this->initToArray($fromArray);
	}
	
	// заполнение вершин и ребер из двумерного массива
	public function initToArray(array $array) 
	{
		foreach($array as $i => $a)
		{
			foreach($a as $j => $weight)
			{
				if($weight > 0)
				{
					$currName = $i . '_' . $j;
					
					$shiftLeft = ($i-1) . '_' . $j;
					$shiftRight = ($i+1) . '_' . $j;
					$shiftTop = $i . '_' . ($j-1);
					$shiftBottom = $i . '_' . ($j+1);
					
					// добавляем ноду
					$this->addNode($currName);
					
					// сдвиг вверх
					if(isset($array[$i-1][$j]))
					{
						if($array[$i-1][$j] > 0 && !isset($this->edges[$currName][$shiftLeft]))
						{
							$this->addEdge($currName, $shiftLeft, $weight);
						}
					}
					
					// сдвиг вниз
					if(isset($array[$i+1][$j]))
					{
						if($array[$i+1][$j] > 0 && !isset($this->edges[$currName][$shiftRight]))
						{
							$this->addEdge($currName, $shiftRight, $weight);
						}
					}
					
					// сдвиг влево
					if(isset($array[$i][$j-1]))
					{
						if($array[$i][$j-1] > 0 && !isset($this->edges[$currName][$shiftTop]))
						{
							$this->addEdge($currName, $shiftTop, $weight);
						}
					}
					
					// сдвиг вправо
					if(isset($array[$i][$j+1]))
					{
						if($array[$i][$j+1] > 0 && !isset($this->edges[$currName][$shiftBottom]))
						{
							$this->addEdge($currName, ($shiftBottom), $weight);
						}
					}
				}
			}
		}
	}
	
	// добавляет ноду
	public function addNode(string $node): void
	{
		$this->edges[$node] = [];
	}
	
	// добавляем ребро
	public function addEdge(string $node1, string $node2, string $weight): void
	{
		$this->edges[$node1][$node2] = $weight;
	}
	
	// возвращает список нодов
	public function getNodes(): iterable
	{
		foreach($this->edges as $node => $edge) 
		{
			yield $node;
		}
	}
	
	// возвращает список нодов массивом
	public function getNodesList(): array
	{
		return $this->edges;
	}
	
	// возвращает ребра
	public function getEdges(string $node1): iterable
	{
		foreach($this->edges[$node1] as $node2 => $weight) 
		{
			yield $node2 => $weight;
		}
	}
	
	// декодировать координаты вершины
	public function decodeNodeCoordinats(string $node): array
	{
		if($this->edges[$node])
		{
			return explode('_', $node);
		}
	}
}