<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ APP_NAME }}</title>
	<style>
		body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f0f8ff; }
		.container { max-width: 1200px; margin: 0 auto; }
		.btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin: 5px; }
		.btn:hover { background: #0056b3; }
		.estacion-btn { display: block; width: 100%; text-align: left; margin: 10px 0; padding: 15px; background: white; border: 1px solid #ddd; border-radius: 8px; }
		.estacion-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px; }
		h1 { color: #333; text-align: center; }
		.loading { text-align: center; padding: 20px; }
	</style>
</head>