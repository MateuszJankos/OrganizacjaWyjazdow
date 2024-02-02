<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Rejestracji</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .registration-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }

        button:hover {
            background-color: #45a049;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .checkbox-label {
            margin-left: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>Formularz Rejestracji</h2>
        
        <form action="zarejestruj.php" method="post">
            <label for="imie">Imię:</label>
            <input type="text" id="imie" name="imie" required>

            <label for="nazwisko">Nazwisko:</label>
            <input type="text" id="nazwisko" name="nazwisko" required>

            <label for="wiek">Wiek:</label>
            <input type="number" id="wiek" name="wiek" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="haslo">Hasło:</label>
            <input type="password" id="haslo" name="haslo" required>

            <label for="potwierdzenieHasla">Potwierdź hasło:</label>
            <input type="password" id="potwierdzenieHasla" name="potwierdzenieHasla" required>

            <div class="checkbox-container">
                <input type="checkbox" id="zgoda" name="zgoda" required>
                <label class="checkbox-label" for="zgoda">Zgadzam się na warunki rejestracji</label>
            </div>

            <button type="submit">Zarejestruj</button>
        </form>
    </div>
</body>
</html>