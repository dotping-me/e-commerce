<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Error Page</title>

    <link rel="stylesheet" href="/css/output.css">
</head>

<body class="w-screen h-screen grid grid-rows-1 grid-cols-1">
    <div id="error-container" class="w-[60%] h-fit m-auto flex flex-col justify-center">
        <img class="red-filter w-24 h-24 m-auto" src="/assets/icons/oops.svg">
        <h2 class="inline-block pl-1 mb-8 font-bold text-4xl text-center text-red-600">OOPS!</h2>

        <p class="text-center mb-2 text-gray-500">It seems that the page you're trying to go to does not exist or it's really an error on our part, sorry!</p>
        <a href="/" class="text-center font-bold text-md text-blue-600 hover:underline">Go back to Home</a>
    </div>
</body>
</html>