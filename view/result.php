<?php
// Шаблон отображения результата
?>
<?php if(!empty($result)): ?>
	<div class="result">
		<?php if(!isset($result['error'])): ?>
			<div class="subtitle">Найден кратчайший путь:</div>
			
			<?php if(isset($result['path']) && $matrix): ?>
				<div class="points flex">
					<?php
						$firstPointPoint = 0;
						$lastPointValue = 0;
					?>
					<?php foreach($result['path'] as $key => $point): ?>
						<?php
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
					<?php endforeach ?>
				</div>
			<?php endif ?>
			
			<?php if(isset($result['sum'])): ?>
				<div class="sum">Ходов без учета веса начальной точки: <span><?= $result['sum']+$lastPointValue-$firstPointPoint ?></span></div>
				<div class="sum">Ходов без учета веса конечной точки: <span><?= $result['sum'] ?></span></div>
				<div class="sum">Полный путь с учетом всех точек: <span><?= $result['sum']+$lastPointValue ?></span></div>
			<?php endif ?>
		<?php else: ?>
			<div class="error">Невозможно найти кратчайший путь</div>
		<?php endif ?>
	</div>
<?php endif ?>