<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
        <title>Form for uploading files</title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <form enctype="multipart/form-data" name="hhh" action="index.php" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="60000" />

            <input type="file" name="userfile[]" /><br>
            <input type="file" name="userfile[]" /><br>
            <input type="file" name="userfile[]" /><br>
            <input type="file" name="userfile[]" /><br>
            <input type="file" name="userfile[]" /><br>
            <input type="submit" name="submitFiles" value="Загрузить" class="submitFiles"/>
        </form>
        <table>
            <thead>
                <tr>
                    <td>№</td>
                    <td>Имя файла</td>
                    <td>Дата загрузки</td>
                </tr>
            </thead>
            <tbody>
                <?php $bd->select_records() ?>
            </tbody>
        </table>
    </body>
</html>
