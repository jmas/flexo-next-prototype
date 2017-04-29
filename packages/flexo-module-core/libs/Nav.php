<?php

namespace Flexo\Core;

class Nav {
	protected $items = [];

	public function __construct($items=[])
	{
		$this->items = $items;
	}

	public function addItem($name, $routeName, $category=null)
	{
		$this->items[] = [
			'name' => $name,
			'routeName' => $routeName,
			'category' => $category,
		];
	}

	public function getItems()
	{
		return $this->items;
	}

	public function getCategories()
	{
		$categories = [];
		foreach ($this->items as $item) {
			$categories[] = $item['category'];
		}
		$categories = array_unique($categories);
		sort($categories);
		return array_map(function($category)
		{	
			return [
				'name' => $category,
				'items' => $this->getCategoryItems($category),
			];
		}, $categories);
	}

	public function getCategoryItems($category=null)
	{
		$items = [];
		foreach ($this->items as $item) {
			if ($item['category'] === $category) {
				$items[] = $item;
			}
		}
		usort($items, function ($item1, $item2) {
		    return $item1['name'] <=> $item2['name'];
		});
		return $items;
	}
}
