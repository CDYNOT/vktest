<?php
// Шаблон отображения результата
?>
<? if(!empty($result)): ?>
	<div class="result">
		<? if(!isset($result['error'])): ?>
			<div class="subtitle">Найден кратчайший путь:</div>
			
			<? if(isset($result['path']) && $matrix): ?>
				<div class="points flex">
					<?
						$firstPointPoint = 0;
						$lastPointValue = 0;
					?>
					<? foreach($result['path'] as $key => $point): ?>
						<?
							$pointCord = Service::decodeCoordinats($point);
							
							// first point
							if($key == 0){
								$firstPointPoint = $matrix[$pointCord[0]][$pointCord[1]];
							}
							// last point
							if($point == end($result['path'])){
								$lastPointValue = $matrix[$pointCord[0]][$pointCord[1]];
							}
						?>
						<div class="point"><?= $matrix[$pointCord[0]][$pointCord[1]] ?></div>
					<? endforeach ?>
				</div>
			<? endif ?>
			
			<? if(isset($result['sum'])): ?>
				<div class="sum">Ходов без учета веса начальной точки: <span><?= $result['sum']+$lastPointValue-$firstPointPoint ?></span></div>
				<div class="sum">Ходов без учета веса конечной точки: <span><?= $result['sum'] ?></span></div>
				<div class="sum">Полный путь с учетом всех точек: <span><?= $result['sum']+$lastPointValue ?></span></div>
			<? endif ?>
		<? else: ?>	
			<div class="error">Невозможно найти кратчайший путь</div>
		<? endif ?>
	</div>
<? endif ?>