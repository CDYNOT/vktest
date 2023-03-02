<?php

/**
 * Класс реализации алгоритма Дейкстры
 * Class Dijkstra
 */
class Dijkstra
{	
	private $graph;
	private $used = [];
	private $esum = [];
	private $path = [];

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}
	
	// получаем короткий путь с дополнительной информацией
	public function getResult(string $frNode, string $toNode): array
	{
		$this->init();
		$this->esum[$frNode] = 0;
		
		while($currNode = $this->findNearestUnusedNode())
		{
			$this->setEsumToNextNodes($currNode);
		}
		
		return $this->getResultInfo($frNode, $toNode);
	}
	
	// обнуляем веса, ребра, пути
	private function init(): void
	{
		foreach($this->graph->getNodes() as $node)
		{
			$this->used[$node] = false;
			$this->esum[$node] = INF;
			$this->path[$node] = '';
		}
	}
	
	// поиск минимального значения
	private function findNearestUnusedNode(): string
	{
		$nearestNode = '';
		foreach($this->graph->getNodes() as $node)
		{
			if(!$this->used[$node])
			{
				if($nearestNode == '' || $this->esum[$node] < $this->esum[$nearestNode])
				{
					$nearestNode = $node;
				}
			}
		}
		return $nearestNode;
	}
	
	// обновляем esum (если меньше предыдущего значения) и собираем путь
	private function setEsumToNextNodes(string $currNode): void
	{
		$this->used[$currNode] = true;
		foreach($this->graph->getEdges($currNode) as $nextNode => $weight)
		{
			if(!$this->used[$nextNode])
			{
				$newEsum = $this->esum[$currNode] + $weight;
				if($newEsum < $this->esum[$nextNode])
				{
					$this->esum[$nextNode] = $newEsum;
					$this->path[$nextNode] = $currNode;
				}
			}
		}
	}
	
	// итоговая функция, возвращающая найденный путь или сообщение об ошибке
	public function getResultInfo(string $frNode, string $toNode): array
	{
		// если найден путь
		if(isset($this->esum[$toNode]) && $this->esum[$toNode] !== INF && isset($this->path[$toNode])) {
			$result['path'] = [$toNode];
			$result['path_string'] = '';
			$result['sum'] = $this->esum[$toNode];
			$result['weight'] = [$this->esum[$toNode]];
			
			while($toNode != $frNode)
			{
				$toNode = $this->path[$toNode];
				$result['path_string'] = $toNode . ' => ' . $result['path_string'];
				array_unshift($result['path'], $toNode);
				array_unshift($result['weight'], $this->esum[$toNode]);
			}
			
			$result['path_string'] = implode(' => ', $result['path']);
		} else {
			// иначе возвращаем error
			$result['error'] = 'path not found';
		}
		
		return $result;
	}
}