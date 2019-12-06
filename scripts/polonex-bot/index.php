<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <h1>Создать заявки</h1>
    <form action="bot.php">
        <div>
            <label>По сколько заявок создать в каждый стакан?</label>
            <input type="text" name="orderCount" value="50">
        </div>
        <br />
        <div>
            <label>Время жизни каждой заявки в сек?</label>
            <input type="text" name="orderLife" value="300">
        </div>
        <input type="hidden" name="key" value="startexp">
        <br />
        <button>Погнали</button>
    </form>
</body>

</html>