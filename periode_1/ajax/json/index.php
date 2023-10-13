<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project - Ajax</title>
</head>

<body>
    <main>
        <button id="btn">Click me</button>
        <div id="content"></div>
    </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        $('#btn').click(async () => {
            const fetchData = await fetch('./concertagenda.json')
                .then(response => response.json());
            $('#content').html(`<h1>artiest: ${fetchData.artiest}</h1>`);
            fetchData.concerten.forEach((item) => {
                for (const key in item) {
                    if (item.hasOwnProperty(key)) {
                        const value = item[key];
                        $('#content').append(`<p>${key}: ${value}</p>`);
                    }
                }
                $('#content').append(`<br>`);
            })
        })
    })
</script>

</html>