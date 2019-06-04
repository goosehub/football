<h1>gooseigniter</h1>

<p>This is a "starting point" I use to start new projects quickly. It uses CodeIgniter 3 as a framework with some additions by myself. It includes the following out of the bow.</p>

<ul>
	<li>Starting controllers, models, and views in application/controllers, application/model, and application/views</li>
	<li>Starting database at database.sql</li>
	<li>Starting scripts at resources/script.js and resources/style.css</li>
	<li>Starting routes at application/config/routes.php</li>
	<li>Starting constants at application/config/constants.php</li>
	<li>Starting images at resources/img/</li>
	<li>CRON system in application/controllers/Cron.php by directly running through CLI application/cron.php</li>
	<li>Twitter Bootstrap at resources/bootstrap/</li>
	<li>jQuery at resources/jquery/</li>
	<li>uploads folder</li>
	<li>Full authentication system</li>
	<li>IP based login and register limits</li>
	<li>AB test system</li>
	<li>Full request database logging</li>
	<li>Abstracted database connection and auth token in auth.php</li>
	<li>Many reusable function in application/config/autoload.php</li>
	<li>A <code>.btn-action</code> css class.</li>
</ul>

<code>auth.php</code> should be handled carefully, per the following steps.

<ul>
	<li>Update <code>auth.php</code> with the database name.</li>
	<li>Run <code>git update-index --assume-unchanged auth.php</code> to ensure you can't commit authentication information to your repo.</li>
	<li>Update <code>auth.php</code> with your real authentication information.</li>
</ul>
