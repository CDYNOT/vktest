<?php
// Шаблон отображения настроек генерации матрицы
?>
<div class="data <?= $fullWidth ?>">
	<div class="settings flex">
		<div class="import">
			<div class="subtitle">Импорт массива из json</div>
			
			<div class="line">
				<div class="field">
					<textarea name="json" placeholder="Вставьте массив в json формате"></textarea>
				</div>
			</div>
			
			<div class="line">
				<div class="field">
					<input type="radio" name="generate" id="generate2" value="2">
					<label for="generate2">cгенерировать из json</label>
				</div>
			</div>
		</div>
		
		<div class="generate">
			<div class="subtitle">Параметры генерации</div>
			
			<div class="line">
				<label for="size_0">Количество строк</label>
				<div class="field">
					<input type="number" step="1" min="2" max="30" class="input" name="size[0]" id="size_0" value="<?= $size[0] ?>">
				</div>
			</div>
			<div class="line">
				<label for="size_1">Количество столбцов</label>
				<div class="field">
					<input type="number" step="1" min="2" max="30" class="input" name="size[1]" id="size_1" value="<?= $size[1] ?>">
				</div>
			</div>
			
			<div class="line">
				<div class="field">
					<input type="radio" name="generate" id="generate1" value="1">
					<label for="generate1">cгенерировать по полям</label>
				</div>
			</div>
		</div>
		
		<div class="submit flex">
			<button type="reset" class="reset_btn" onclick="document.location.href = '/'">Сбросить</button>
			<button type="submit" class="submit_btn">Сгенерировать</button>
		</div>
	</div>
	
	<? require_once('result.php') ?>
</div>