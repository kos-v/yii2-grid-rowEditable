# Yii2 Grid RowEditable

Yii2 расширение для редактирования данных в [`GridView`](https://www.yiiframework.com/doc/api/2.0/yii-grid-gridview)

## Установка
Выполните
```bash
$ composer require kosv/yii2-grid-roweditable:1.0.*
```
Или добавьте
```json
"kosv/yii2-grid-rowEditable": "1.0.*"
```
в секцию `require` файла `composer.json`.

## Определения
**Данное расширение** - Yii2 Grid RowEditable.   
**YourGridView** - для использования данного расширения, вам нужно иметь/создать дочерний класс от [`GridView`](https://www.yiiframework.com/doc/api/2.0/yii-grid-gridview),
поэтому в контексте документации, ваш `GridView` будем называть `YourGridView`.  
**YourSaveForm** - вам нужно будет создать форму, в которой будет выолнятся валидация и сохранение данных.
В контексте даннной документации, такую форму будем называть `YourSaveForm`.  

## Как использовать?

1. Нужно подключить данное расширение к `YourGridView`.
2. Нужно реализовать `YourSaveForm`, - в данном классе будет выполнятся процесс валидации и сохранения данных.
3. В экшене вашего контроллера, создать объект `YourSaveForm` и написать условие для сохранения данных формы.
4. Нужно вывести `YourGridView` в вашем View, и указать обязательные общие параметры редактирования.
5. В список столбцов добавить `Kosv\Yii2Grid\RowEditable\Select\CheckboxColumn` - это столбец чекбоксов, который позволяет выбирать строки.
6. Вывести кнопку сохранения изменений.

### Шаг 1. Инициализация YourGridView

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
### Шаг 2. Создание YourSaveForm

Создайте класс формы, и унаследуйти его от `yii\base\Model`(или от любого другого потомка `yii\base\Model`) 

```php
namespace app\models;

use yii\base\Model;

/**
 * @property array $editingRows
 */
class YourSaveForm extends Model
{
}
```

К `YourSaveForm` подключите итерфейс `Kosv\Yii2Grid\RowEditable\Form\SaveFormInterface`
и трейт `Kosv\Yii2Grid\RowEditable\Form\SaveFormTrait`

```php
namespace app\models;

use Kosv\Yii2Grid\RowEditable\Form\SaveFormInterface;
use Kosv\Yii2Grid\RowEditable\Form\SaveFormTrait;
use yii\base\Model;

/**
 * @property array $editingRows
 */
class YourSaveForm extends Model implements SaveFormInterface
{
    use SaveFormTrait;
}
```

В `YourSaveForm` реализуйте методы: `validateEditableRows`(отвечает за валидацию данных), и `saveEditableRows`(отвечает за сохранение данных).
По умолчанию, данные методы не имеют реализации, поэтому вы должы сами позаботится о том, как будут валидироваться и сохраняться ваши данные. 

```php
namespace app\models;

use Kosv\Yii2Grid\RowEditable\Form\SaveFormInterface;
use Kosv\Yii2Grid\RowEditable\Form\SaveFormTrait;
use yii\base\Model;

/**
 * @property array $editingRows
 */
class YourSaveForm extends Model implements SaveFormInterface
{
    use SaveFormTrait;
    
    /**
     * @return bool
     */
    public function validateEditableRows()
    {
        // TODO: Ваша логика валидации данных из массива $this->editingRows
    }
    
    /**
     * @return bool
     */
    public function saveEditableRows()
    {
        // TODO: Ваша логика сохранения данных из массива $this->editingRows
    }
}
```

### Шаг 3. Создание и сохранение YourSaveForm в экшене вашего контроллера

```php
public function actionIndex()
{
    $gridSaveForm = new app\models\YourSaveForm();
    if ($gridSaveForm->load(Yii::$app->request->post()) &&
        $gridSaveForm->validate() &&
        $gridSaveForm->validateEditableRows()) {
        
        $gridSaveForm->saveEditableRows();
    }
    
    return $this->render('index', [
        'gridSaveForm' => $gridSaveForm,
    ]);
}
```

### Шаг 4. Вывод и обязательные параметры

Выведите `YourGridView` в представлении и укажите обязательный параметр `form`

```php
<?php
/** @var $gridSaveForm app\models\YourSaveForm */

use app\widgets\YourGridView;

echo YourGridView::widget([
    ...
    'commonEditParams' => [
        'form' => $gridSaveForm,
        ...
    ],
])
```

### Шаг 5. Колонка с чекбоксами для выбора строки

В массив колонок добавьте `Kosv\Yii2Grid\RowEditable\Select\CheckboxColumn`
```php
<?php
/** @var $gridSaveForm app\models\YourSaveForm */

use Kosv\Yii2Grid\RowEditable\Select\CheckboxColumn;
use app\widgets\YourGridView;

echo YourGridView::widget([
    ...
    'commonEditParams' => [
        'form' => $modelOfSaveForm,
        ...
    ],
    'columns' => [
        ...
        ['class' => CheckboxColumn::class],
    ],
])
```

### Шаг 6. Кнопка для сохранения данных

В любом месте страницы, выведите кнопку для сохранения данных
```php
<?php echo Html::button('Save', [
    'class' => \Kosv\Yii2Grid\RowEditable\Config\EditConfigInterface::DEFAULT_CLASS_SAVE_BTN
]) ?>
```

## Конфигурирование

Данное расширение можно конфигурировать как для отдельных столбцов, так и использовать общии парметры конфигурации.  
Более подробную информации о всех праметрах можно получить в разделе [описания параметров конфигурации](#описание-параметров-конфигурации)

### Общии параметры конфигурации
Данный вид парметров задаётся в `commonEditParams`:
```php
echo YourGridView::widget([
    ...
    'commonEditParams' => [
        // Общие параметры
        'form' => $saveForm,
    ],
])
```

### Конфигурация столбцов

Если в массиве columns вашего `YourGridView`, есть столбцы без явно указанного типа (задаётся через поле `class`),
то по умолчанию будет использоваться столбец с типом `Kosv\Yii2Grid\RowEditable\EditableRowColumn`.  
Все столбцы типа `Kosv\Yii2Grid\RowEditable\EditableRowColumn` можно конфигурируются точно также как и `commonEditParams`,
только параметры кофигурации задаются через поле `editParams`

```php
echo YourGridView::widget([
    ...
    'commonEditParams' => [
        // Общие параметры редактирования
        'form' => $saveForm,
        'input' => \Kosv\Yii2Grid\RowEditable\Input\Input::class
        ...
    ],
    'columns' => [
        [
            ...
            'editParams' => [
                // Параметры редактирования столбца 
                'input' => \Kosv\Yii2Grid\RowEditable\Input\DropDownList::class
                ...
            ],            
        ],
    ],
])
```

Список параметров из `commonEditParams`, которые нельзя предопределить в столбце:
`prefix`, `gridCssClass`, `selectMode`, `saveAction`, `saveMethod`, `saveButton`.


## Описание параметров конфигурации
```php
# Модель формы в которой выполняется валидация и сохранение данных.
# - Обязательный параметр
# - Тип yii\base\Model
# - Нельзя предопределить в столбце
'form' => $saveFrom,

# Атрибут формы в который будут загружатся данные в виде массива.
# - Необязательный параметр
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
# - Необязательный параметр
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

# Html шаблон текста ошибки. Выводится при неудачной валидации, под input'ом
# - Необязательный параметр
# - Тип string
# - Значение по умолчанию '<p>{error}</p>'
# - Можно предопределить в столбце
'validationErrorLayout' => '<p>{error}</p>'
```
