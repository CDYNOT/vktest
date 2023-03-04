<?php

/**
 * Класс графа
 * Class Graph
 */
class Graph
{
	private $edges;

    /**
     * @param array $fromArray
     */
    public function __construct(array $fromArray = [])
	{
		$this->edges = [];
		$this->initToArray($fromArray);
	}

    /**
     * Инициализирует граф из переданного массива
     * @param array $fromArray
     * @return void
     */
    public function initFromArray(array $fromArray = []): void
	{
		$this->initToArray($fromArray);
	}

    /**
     * Заполнение вершин и ребер из двумерного массива
     * @param array $array
     * @return void
     */
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

    /**
     * Добавляет ноду
     * @param string $node
     * @return void
     */
    public function addNode(string $node): void
	{
		$this->edges[$node] = [];
	}

    /**
     * Добавляем ребро
     * @param string $node1
     * @param string $node2
     * @param string $weight
     * @return void
     */
    public function addEdge(string $node1, string $node2, string $weight): void
	{
		$this->edges[$node1][$node2] = $weight;
	}

    /**
     * Возвращает список нодов
     * @return iterable
     */
    public function getNodes(): iterable
	{
		foreach($this->edges as $node => $edge) 
		{
			yield $node;
		}
	}

    /**
     * Возвращает список нодов массивом
     * @return array
     */
    public function getNodesList(): array
	{
		return $this->edges;
	}

    /**
     * Возвращает ребра
     * @param string $node1
     * @return iterable
     */
    public function getEdges(string $node1): iterable
	{
		foreach($this->edges[$node1] as $node2 => $weight) 
		{
			yield $node2 => $weight;
		}
	}

    /**
     * Декодировать координаты вершины
     * @param string $node
     * @return array
     */
    public function decodeNodeCoordinats(string $node): array
	{
		if($this->edges[$node])
		{
			return explode('_', $node);
		}
        return [];
    }
}