# Yii2 Grid RowEditable

Yii2 расширение для редактирования данных в [`GridView`](https://www.yiiframework.com/doc/api/2.0/yii-grid-gridview)

**Расширение находится на стадии разработки. На данный момент осталось реализовать валидацию, протестировать,
и дописать документацияю**
## Установка
*TODO: написать документацию*

## Терминология
**Данное расширение** - Yii2 Grid RowEditable.   
**YourGridView** - чтобы использовать данное расширение, вам нужно иметь/создать дочерний класс от [`GridView`](https://www.yiiframework.com/doc/api/2.0/yii-grid-gridview),
поэтому в контексте данной документации, ваш `GridView` будем называть `YourGridView`

## Как использовать

Весь этап можно разделить на 5 шагов:
1. Нужно подключить данное расширение к `YourGridView`.
2. Нужно создать Model-форму в которой будет выполнятся процесс валидации и сохранения данных.
3. Нужно вывести `YourGridView` в вашем View и указать обязательные общие параметры редактирования.
4. В список столбцов добавить `Kosv\Yii2Grid\RowEditable\Select\CheckboxColumn` - который позволяет выбирать строки.
5. Вывести кнопку "Сохранить изменения".

### Шаг 1. Инициализация

Если в приложении нет дочернего класса [`GridView`](https://www.yiiframework.com/doc/api/2.0/yii-grid-gridview),
то создайте его в любом месте вашего приложения
```php
namespace app\widgets;

use yii\grid\GridView as YiiGridView;

class YourGridView extends YiiGridView
{ 
}
```
К `YourGridView` подключите интерфейс `Kosv\Yii2Grid\RowEditable\EditableGridInterface`,  
и трейт `Kosv\Yii2Grid\RowEditable\EditableGridTrait`

```php
namespace app\widgets;

use Kosv\Yii2Grid\RowEditable\EditableGridInterface;
use Kosv\Yii2Grid\RowEditable\EditableGridTrait;
use yii\grid\GridView as YiiGridView;

class YourGridView extends YiiGridView implements EditableGridInterface
{
    use EditableGridTrait;
}
```
### Шаг 2. Создание формы

Создайте форму и поле формы для валидации и сохранения данных.

```php
namespace app\models;

use yii\base\Model;

class YourGridSaveForm extends Model
{
    public $editingRows;
    
    public function rules()
    {
        return [
            # TODO: Ваши правила валидации
        ];
    }
    
    public function save()
    {
        # TODO: Сохранение данных из $this->editingRows
    {
}
```

### Шаг 3. Вывод и обязательные параметры

Выведите `YourGridView` в представлении и укажите обязательные параметры: модель формы и поле формы

```php
<?php
/** @var $saveForm app\models\YourGridSaveForm */

echo YourGridView::widget([
    ...
    'commonEditParams' => [
        'form' => $modelOfSaveForm,
        'formAttribute' => 'editingRows',
        ...
    ],
])
```

### Шаг 4. Колонка с чекбоксами для выбора строки

В вывод `YourGridView` добавьте колонку с чекбоксом `Kosv\Yii2Grid\RowEditable\Select\CheckboxColumn`
```php
<?php
/** @var $saveForm app\models\YourGridSaveForm */

use Kosv\Yii2Grid\RowEditable\Select\CheckboxColumn;

echo YourGridView::widget([
    ...
    'commonEditParams' => [
        'form' => $modelOfSaveForm,
        'formAttribute' => 'editingRows',
        ...
    ],
    'columns' => [
        ...
        ['class' => CheckboxColumn::class],
    ],
])
```

### Шаг 5. Кнопка сохранения данных

В любом месте страницы, выведите кнопку для сохранения данных
```php
<?= Html::button('Save', [
    'class' => \Kosv\Yii2Grid\RowEditable\Config\EditConfigInterface::DEFAULT_SAVE_BTN
]) ?>
```

## Конфигурирование

После подключения трейта `Kosv\Yii2Grid\RowEditable\EditableGridTrait`, ваш `GridView` можно настроить на использование 
общей кофигурации для все столбцов `Kosv\Yii2Grid\RowEditable\EditableRowColumn`, то есть вам не нужно указывть
одни и те же параметры для каждого столбца.

### Общии параметры конфигурации
```php
echo YourGridView::widget([
    # Параметры GridView
    ...
    
    # Параметры RowEditable для всех столбцов
    'commonEditParams' => [
        # Модель формы в которой выполняется валидация и сохранение данных.
        # - Обязательный параметр
        # - Тип yii\base\Model
        # - Нельзя предопределить в столбце
        'form' => $formModel,
        
        # Атрибут формы в который будут загружатся данные в виде массива.
        # - Обязательный параметр
        # - Тип string
        # - Значение по умолчанию 'editingRows'
        # - Нельзя предопределить в столбце
        'formAttribute' => 'editingRows',
        
        # Вклчить режим редактирования
        # - Необязательный параметр
        # - Тип boolean
        # - Значение по умолчанию true
        # - Можно предопределить в столбце
        'enable' => true
        
        # CSS класс для RowEditable. Будет добавлен к виджету GridView
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию 'gre-grid-view'
        # - Нельзя предопределить в столбце
        'gridCssClass' => 'gre-grid-view',
        
        # Html input для редактирования значений столбца
        # - Обязательный параметр
        #
        # - Тип \Closure. Функция должна возвращать строку с Html 
        # - Тип array. В массиве должна быть представлена кофигурация реализации Kosv\Yii2Grid\RowEditable\Input\InputInterface
        # - Тип string. Строка дожна быть именем класса, который реализует Kosv\Yii2Grid\RowEditable\Input\InputInterface
        #
        # - Значение по умолчанию Kosv\Yii2Grid\RowEditable\Input\Input::class
        # - Можно предопределить в столбце
        'input' => Kosv\Yii2Grid\RowEditable\Input\Input::class,
        
        # Html класс для блока с input'ом
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию 'input-wrap'
        # - Можно предопределить в столбце
        'inputWrapHtmlClass' => 'input-wrap',
        
        # Html тег для блока с input'ом
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию 'div'
        # - Можно предопределить в столбце
        'inputWrapHtmlTag' => 'div',
        
        # Префикс плагина. Будет добавлятся к html data-атрибутам
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию 'gre'
        # - Нельзя предопределить в столбце
        'prefix' => 'gre',
        
        # Экшен для формы сохранения данных
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию ''
        # - Нельзя предопределить в столбце
        'saveAction' => '',
        
        # Кнопка для формы сохранения данных
        # - Необязательный параметр
        # - Тип string. jQuery селектор кнопки
        # - Значение по умолчанию '.gre-save-btn'
        # - Нельзя предопределить в столбце
        'saveButton' => '.gre-save-btn',
        
        # При true, форма будет сохранятся через AJAX
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию false
        # - Нельзя предопределить в столбце
        'saveAjax' => false,
        
        # HTTP метод с помощью которого будет выполнятся сохранение формы
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию 'POST'
        # - Нельзя предопределить в столбце
        'saveMethod' => 'POST',
        
        # Битовый флаг режима выбора строк.
        #
        # В текущей версии поддерживается только EditConfigInterface::SELECT_MODE_CHECKBOX.
        # Если включён EditConfigInterface::SELECT_MODE_CHECKBOX, то YourGridView
        # должен содержать столбец Kosv\Yii2Grid\RowEditable\Select\CheckboxColumn
        # или любой другой столбец с реализацией Kosv\Yii2Grid\RowEditable\Select\CheckboxColumnInterface.
        # 
        # - Необязательный параметр
        # - Тип integer
        # - Значение по умолчанию EditConfigInterface::SELECT_MODE_CHECKBOX
        # - Нельзя предопределить в столбце
        'selectMode' => Kosv\Yii2Grid\RowEditable\Config\EditConfigInterface::SELECT_MODE_CHECKBOX,
        
        # Html класс для блока с выводимыми данными в grid-ячейке
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию 'output-wrap'
        # - Можно предопределить в столбце
        'outputWrapHtmlClass' => 'output-wrap',
        
        # Html тег для блока с выводимыми данными в grid-ячейке
        # - Необязательный параметр
        # - Тип string
        # - Значение по умолчанию 'div'
        # - Можно предопределить в столбце
        'outputWrapHtmlTag' => 'div',
    ],
]);
```

### Конфигурация для отдельных столбцов
*TODO: написать документацию*