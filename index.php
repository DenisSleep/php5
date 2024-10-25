<?php
try {
    $host = 'localhost';
    $dbname = 'php5';
    $username = 'root';
    $password = '';
    $dsn = "mysql:host=$host; dbname=$dbname";
    $connection = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {
    echo 'Возникла ошибка. Текст ошибки: ' . $exception->getMessage();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        $sql_add = "INSERT INTO `card` (`id`, `name`, `description`, `price`, `category`) VALUES (NULL, '$name', '$description', '$price', '$category')";
        $prepare = $connection->query($sql_add);
    }


    if (isset($_POST['search'])) {
        $txt = $_POST['txt'];

        $dop = "WHERE `name` LIKE '%" . $txt . "%' ";
        $sql = "SELECT * FROM `card` $dop";
        $prepare = $connection->query($sql);
    } else {
        $sql = "SELECT * FROM `card`";
    }

    if (isset($_GET['category'])) {
        $cat = $_GET['category'];
        $dop = "WHERE `category` LIKE '%" . $cat . "%' ";
        $sql = "SELECT * FROM `card` $dop";
        $prepare = $connection->query($sql);
    } else {
        $sql = "SELECT * FROM `card`";
    }

    if (isset($_POST['search']) && isset($_GET['category'])) {
        $txt = $_POST['txt'];
        $cat = $_GET['category'];

        $dop = "WHERE `category` LIKE '%" . $cat . "%' AND `name` LIKE '%" . $txt . "%' ";
        $sql = "SELECT * FROM `card` $dop";
    }



    ?>

    <section>
        <form action="" method="post" name="add">
            <input type="text" name="name" placeholder="Название">
            <input type="text" name="description" placeholder="Описание">
            <input type="text" name="price" placeholder="Глав">
            <select name="category">
                <option value="Манга">Манга</option>
                <option value="Манхва">Манхва</option>
            </select>
            <input type="submit" value="Добавить товар" name="add">
        </form>
    </section>

    <section>
        <form action="" name="search" method="post">
            <input type="text" name="txt" placeholder="Поиск">
            <input type="submit" value="Найти" name="search">
        </form>
    </section>

    <section>
        <a href="?page=index&category=Манга">Манга</a>
        <a href="?page=index&category=Манхва">Манхва</a>
    </section>

    <section>
        <div>
            <?
            $sql = "SELECT * FROM `card` $dop";
            $error = $connection->query($sql)->fetchColumn();
            if ($error == 0) { ?>
            <p>По вашему запросу ничего не найдено</p> <a style="color: red;" href="?page=index">Вернуться к каталогу</a>
                <? }
            if ($result = $connection->query($sql)) {
                foreach ($result as $card) { ?>
                    <div class="card">
                        <h2 class="name"><?= $card['name'] ?></h2>
                        <p class="desc"><?= $card['description'] ?></p>
                        <p class="price"><?= $card['price'] ?> глав</p>
                    </div>
            <? }
            }

            ?>
        </div>
    </section>
</body>

</html>