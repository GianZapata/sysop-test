<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sysop - <?= $title ?? "Dashboard" ?> </title>

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

   <script src="https://cdn.tailwindcss.com"></script>
   <script>
      tailwind.config = {
         theme: {
         extend: {
            fontFamily: {
                  'poppins': ['Poppins', 'sans-serif'],
               }
            }
         }
      }
   </script>
   
   <link rel="stylesheet" href="/build/css/app.css">

</head>
<body>

   <?php include_once __DIR__ .'/../templates/admin-header.php'; ?>

   <div className="min-h-screen">
      <main class="py-5">

         <?php include_once __DIR__ .'/../templates/admin-sidebar.php'; ?>

         <div class="px-4 sm:ml-64">
            <div class="px-4 mt-14">
               <?php echo $content ?>
            </div>
         </div>
         
      </main>
   </div> 
   
   <script src="/build/js/main.min.js"></script>
</body>
</html>