<?php
    require_once('..\Projet4\model\AdminConnexion.php');
    require_once('..\Projet4\model\PostManage.php');
    require_once('..\Projet4\model\CommentManage.php');
    require_once('..\Projet4\model\ReportManage.php');

class FrontendController
{
    function homePage()
    {
        require('..\Projet4\view\frontend\listTicketsView.php');
    }
    
    function postReportView()
    {
        $reportManage = new ReportManage();
        $getReportView = $reportManage->getReport($_GET['id']);  
        
        require('..\Projet4\view\frontend\postReport.php');
    }
    
    public function listPosts()
    {
        $postManager = new PostManage();
        $posts = $postManager->getPosts();
        return $posts;
        require('..\Projet4\view\frontend\listTicketsView.php');
    }
    
    function post()
    {
        $postManage = new PostManage();
        $commentManage = new CommentManage();
        
        $post = $postManage->getPost($_GET['id']);
        $comments = $commentManage->getComments($_GET['id']);
        
        require('..\Projet4\view\frontend\postView.php');
        exit;
        return $post;
    }
    
    function addComment($postId, $author, $comment)
    {
        $commentManage = new CommentManage();
        
        $lineComment = $commentManage->postComment($postId, $author, $comment);
        
        if ( $lineComment === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            header('Location: index.php?action=post&id=' . $postId);
        }
    }
    
    function postReport($commentId)
    {
        $reportManage = new ReportManage();
        
        $reported = $reportManage->postReports($commentId);
        
        header('Location: index.php?action=postReportView&id=' . $commentId . '&report=success');
        exit;
    }
}