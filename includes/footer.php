        <!-- Footer -->
        <footer>           
            <div class="row"> <hr />
                <div class="col-lg-12" style="background-color:blue; color:white; position: fixed;
                        right: 0;  left: 0; bottom:0;    z-index: 1000;">
                    <p style="margin: 20px 0;">Copyright &copy; Powered by John 2021 in Sydney
                    <?php 
                       echo 'Role: '.  $_SESSION['user_role'];
                    ?>
                </p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="js/scripts.js"></script>

</body>

</html>