<?php

/**
 * Класс вершины
 * Class Node
 */
class Node 
{
	/** @var string */
	private $item;
	
	/** @var Node */
	private $next;
	
	public function __construct(string $item, ?Node $next = null)
	{
		$this->item = $item;
		$this->next = $next;
	}
	
	// получаем имя ноды
	public function getItem(): string
	{
		return $this->item;
	}
	
	// получаем ссылку на ноду
	public function getNext(): ?Node
	{
		return $this->next;
	}

	// устанавливаем ноду
	public function setNext(Node $node): void
	{
		$this->next = $node;
	}
}