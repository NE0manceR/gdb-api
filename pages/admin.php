<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/admin.css">
    <title>gdb</title>
</head>

<body>
    <main class="main">
        <aside class="main__aside">
            <h2>Division 2</h2>
            <ul>
                <li>
                    Brands
                </li>
            </ul>
        </aside>
        <section class="main__content">
            <form id="update_brand" class="" action="">
                <label for="">
                    Brand name
                    <select name="brandName" id="brandName">
                        <option value="Alex Brand" selected>Select brand</option>
                    </select>
                </label>
                <label for="">
                    Core attribute
                    <select name="brandType" id="brandAttribute">
                        <option value="" disabled selected>Select attribute</option>
                        <option value="weapon">Weapon</option>
                        <option value="skill">Skill</option>
                        <option value="armor">Armor</option>
                    </select>
                </label>
                <label for="">
                    Bonus of one item
                    <select name="oneItem" id="brandOneItem">
                        <option value="" disabled selected>Select bonus</option>
                    </select>
                </label>
                <label for="">
                    Bonus of two items
                    <select name="twoItems" id="brandTwoItem">
                        <option value="" disabled selected>Select bonus</option>
                    </select>
                </label>
                <label for="">
                    Bonus of three items
                    <select name="threeItems" id="brandThreeItem">
                        <option value="" disabled selected>Select bonus</option>
                    </select>
                </label>

                <input name="brandImg" type="file">

                <label for="">
                    Група
                    <select class="group_select" name="group_id" value="0">
                        <option value='0' disabled selected>Оберіть групу</option>
                    </select>
                </label>
                <button type="button" class="btn main-green add-cat-btn">Додати запис</button>
            </form>
        </section>
    </main>
    <script src="../scripts/assets/jquery.js"></script>
    <script src="../scripts/script.js"></script>
    <script src="../scripts/API/get_data.js"></script>
</body>

</html>