<?php include('shared/header.php'); ?>
<style>
.sidebar {
    width: 250px;
    background-color: #fff; /* White sidebar background */
    padding: 15px;
    border-right: 1px solid #ccc; /* Light border */
}

.sidebar h2 {
    margin-bottom: 15px;
    color: #333; /* Dark text color */
}

.sidebar ul {
    list-style: none;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    color: #333; /* Dark text color */
    text-decoration: none;
    display: block;
    padding: 8px 0;
    transition: background-color 0.3s ease;
}

.sidebar ul li a:hover {
    background-color: #f0f0f0; /* Hover background color */
}

.main-container {
    display: flex;
    flex-direction: row;
}

.user-dashboard {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    padding: 20px;
}

.content {
    flex: 1;
    padding: 20px;
}

</style>

<?php
    include_once 'shared/database.php';
    include_once 'admin/shared/recipeHandler.php';

    $conn = new Database();
    $recipeHandler = new RecipeHandler($conn);

    $user_id = $_SESSION['user_id'];

    $recipesList = $recipeHandler->getAllRecipes($user_id);
?>

    <div class="user-dashboard">
        <aside class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Messages</a></li>
                <li><a href="#">Notifications</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </aside>

        <main class="main-container">
            <!-- <section class="user-info">
                <h2>User Information</h2>
                <p>Email: user@example.com</p>
                <p>Joined: January 1, 2023</p>
            </section> -->

            <section class="content">
            <?php
                foreach ($recipesList as $post) {
			        $date = date_create($post['created_at']);					
			        $message = str_replace("\n\r", "<br><br>", $post['description']);
			?>
			    <div class="col-md-10 blogShort">
        	
			        <?php if (!empty($post['image_url'])) {?>
			            <img src="<?php echo $post['image_url'] ?>" width="250">
        	        <?php } ?>
			
				    <h3><a href="view_post.php?id=<?php echo $post['recipe_id']; ?>"><?php echo $post['title']; ?></a></h3>		
			        <em><strong>Published on</strong>: <?php echo date_format($date, "d F Y");	?></em>
			        <em><strong>Category:</strong> <a href="#" target="_blank"><?php echo $post['difficulty_level']; ?></a></em>
			        <br><br>
			        <article>
			            <p><?php echo $message; ?> 	</p>
			        </article>
			        <a class="btn btn-blog pull-right" href="view_post.php?id=<?php echo $post['recipe_id']; ?>">READ MORE</a> 
			    </div>
		    <?php } ?>  
            </section>
        </main>
    </div>

<?php include('shared/footer.php');?>