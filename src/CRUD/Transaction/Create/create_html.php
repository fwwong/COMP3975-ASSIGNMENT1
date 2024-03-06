<?php include("../../../include/_header.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <style>
        /* Add custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        label {
            font-weight: bold;
        }

        input[type="date"],
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            width: 100%;
            background-color: #4caf50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <form action="create.php" method="post">
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br>
        <label for="name">Vender:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="expense">Expense:</label><br>
        <input type="number" id="expense" name="expense" min="0" step="0.01" oninput="deposit.value=''"><br>
        <label for="deposit">Deposit:</label><br>
        <input type="number" id="deposit" name="deposit" min="0" step="0.01" oninput="expense.value=''"><br>
        <input type="submit" value="Submit">
            <button onclick="location.href='../../Transaction/Read/read_html.php'">Back</button>
</body>
    </form>

    <script>
        let expense = document.getElementById('expense');
        let deposit = document.getElementById('deposit');

        expense.addEventListener('input', function() {
            if (this.value !== '') {
                deposit.value = '';
            }
        });

        deposit.addEventListener('input', function() {
            if (this.value !== '') {
                expense.value = '';
            }
        });
    </script>



</html>

<?php include("../../../include/_footer.php") ?>
