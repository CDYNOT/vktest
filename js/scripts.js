'use strict';

var checked = [];

const begin = document.getElementById('begin')
const end = document.getElementById('end')
const points = document.querySelectorAll('.matrix input[type=checkbox]')
const pointsWeights = document.querySelectorAll('.matrix input[type=text]')
const sizes = document.querySelectorAll('.generate input[type=number]')

// инициализируем массив точек
initChecked()

// инициализируем массив отмеченных точек при обновлении страницы
function initChecked()
{
	if(begin.value)
	{
		checked.push(begin.value)
	}
	if(end.value)
	{
		checked.push(end.value)
	}
}

// слушатель для клика по checkbox
if(points.length){
	for (var i = 0; i < points.length; i++)
	{
		points[i].addEventListener('click', clickPoint)
	}
}

// слушатель для input размерности матрицы
if(sizes.length){
	for (var i = 0; i < sizes.length; i++)
	{
		sizes[i].addEventListener('keyup', validateInputSize)
	}
}

// слушатель для клика по весу точки
/* if(pointsWeights.length){
	for (var i = 0; i < pointsWeights.length; i++)
	{
		pointsWeights[i].addEventListener('click', clickPointWeight)
	}
} */

// слушатель для изменения веса точки
if(pointsWeights.length){
	for (var i = 0; i < pointsWeights.length; i++)
	{
		pointsWeights[i].addEventListener('keyup', changePointWeight)
	}
}

// функция клика по checkbox
function clickPoint(e)
{
	let value = this.value
	if(checked.includes(value)){
		checked.splice(checked.indexOf(value), 1)
	}else{
		if(checked.length > 1){
			checked.splice(0, 1)
			checked.push(value)
		}else{
			checked.push(value)
		}
	}
	
	// перерисовываем точки
	redrawPoints()
	
	// устанавливаем зачения в begin и end
	setBeginEndInputsValue()
	
	// отправка формы
	submitForm()
}

// функция отправки формы
function submitForm()
{
	document.getElementById('labyrinth').submit()
}

// устанавливаем зачения в begin и end
function setBeginEndInputsValue()
{
	if(typeof checked[0] !== 'undefined'){
		begin.value = checked[0]
	}else{
		begin.value = ''
	}
	
	if(typeof checked[1] !== 'undefined'){
		end.value = checked[1]
	}else{
		end.value = ''
	}
}

// функция клика по весу point
/* function clickPointWeight(e)
{
	this.parentNode.click()
} */

// функция клика по весу point
function changePointWeight(e)
{
	// валидируем введенное значение
	validateInputWeight(e, this)
	// изменяем активность point
	changeStatePointWeight(e, this)
	// отправляем форму
	submitForm()
}

// функция измнения активности point
function changeStatePointWeight(e, element)
{
	let value = element.value
	let dataValue = element.parentNode.dataset.value
	let point = document.querySelectorAll('.matrix input[type=checkbox][value="'+dataValue+'"]')[0]
	
	if(value > 0){
		point.disabled = false
	}else{
		point.disabled = true
	}
	
	// обнуляем массив координат
	checked = []
	// перерисовываем точки
	redrawPoints()
}

// функция валидации input точки
function validateInputWeight(e, element)
{
	let min = 0
	let max = 9
	var value = element.value.replace(/[^0-9]/g, 0)
	value = Math.round(value)
	if(value < min)
	{
		value = min
	}
	if(value > max)
	{
		value = max
	}
	element.value = value
}

// функция валидации input размерности матрицы
function validateInputSize(e)
{
	let min = 2
	let max = 30
	var value = this.value.replace(/[^0-9]/g, 2)
	value = Math.round(value)
	
	console.log(value)
	
	if(value < min)
	{
		value = min
	}
	if(value > max)
	{
		value = max
	}
	this.value = value
}

// проходимся по точкам и расставляем классы
function redrawPoints()
{
	for (var i = 0; i < points.length; i++)
	{
		let value = points[i].value
		let label = points[i].parentNode.querySelectorAll('label[data-value="'+value+'"]')[0]
		if(checked.includes(value)) {
			let index = checked.indexOf(value)
			
			if(index == 0)
			{
				if(label.classList.contains('end'))
				{
					label.classList.remove('end')
				}
				if(!label.classList.contains('begin'))
				{
					label.classList.add('begin')
				}
			}
			if(index == 1)
			{
				if(label.classList.contains('begin'))
				{
					label.classList.remove('begin')
				}
				if(!label.classList.contains('end'))
				{
					label.classList.add('end')
				}
			}			
		} else {
			if(label.classList.contains('begin'))
			{
				label.classList.remove('begin')
			}
			if(label.classList.contains('end'))
			{
				label.classList.remove('end')
			}
			
			points[i].checked = false;
		}
	}
}