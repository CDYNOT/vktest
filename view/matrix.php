<?php
// Шаблон отображения матрицы
?>
<? if($matrix): ?>
	<div class="matrix flex <?= $fullWidth ?>">
		<div class="message_wrap">
			<div class="message">Отметьте начальную и конечную точки. <br>Веса ячеек можно изменять динамически.</div>
		</div>
	
		<div class="lines flex">
			<? foreach($matrix as $i => $a): ?>
				<div class="line flex">
					<? foreach($a as $j => $weight): ?>
						<?
							$checked = '';
							$begin = '';
							$end = '';
							if($coordinates['begin'])
							{
								$checked = (($i . '_' . $j) == $coordinates['begin']) ? 'checked' : $checked;
								$begin = ($i . '_' . $j) == $coordinates['begin'] ? 'begin' : '';
							}
							if($coordinates['end'])
							{
								$checked = (($i . '_' . $j) == $coordinates['end']) ? 'checked' : $checked;
								$end = ($i . '_' . $j) == $coordinates['end'] ? 'end' : '';
							}
							
							$disabled = $weight == 0 ? 'disabled' : '';
							
							if(isset($result['path'])) {
								$path = Service::inArray($result['path'], [$i, $j]) ? 'path' : '';
							} else {
								$path = '';
							}
							
							$class = implode(' ', [$begin, $end, $path]);
						?>
						
						<input type="checkbox" id="matrix_point_<?= $i ?>_<?= $j ?>" value="<?= ($i.'_'.$j) ?>" <?= $checked ?> <?= $disabled ?>>
						<label for="matrix_point_<?= $i ?>_<?= $j ?>" class="<?= $class ?>" data-value="<?= ($i.'_'.$j) ?>">
							<input type="text" name="matrix[<?= $i ?>][<?= $j ?>]" value="<?= $weight ?>">
						</label>
					<? endforeach ?>
				</div>
			<? endforeach ?>
		</div>
	</div>
<? endif ?>