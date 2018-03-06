// AUTO SCROLL MESSAGE DIV FIRST TIME END
app.directive('ngEnter', function () {			// custom directive for sending message on enter click
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13 && !event.shiftKey) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
app.directive("editableText", function () {
    return {
        controller: 'EditorController',
        restrict: 'C',
        replace: true,
        transclude: true,
    };
});
app.controller('EditorController', ['$scope', function ($scope) {
        $scope.handlePaste = function (e) {
            e.preventDefault();
            e.stopPropagation();
            var value = e.originalEvent.clipboardData.getData("Text");
            document.execCommand('inserttext', false, value);
        };
    }]);

app.controller('questionDetailsController', function ($scope, $http) {
    questionData();
    function questionData() {
        $('#loader').show();
        $http.get(base_url + "userprofile_page/question_data/?question=" + question).then(function (success) {
            $('#loader').hide();
            $scope.postData = success.data;
        }, function (error) {});
    }

    $scope.post_like = function (post_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.message == 1) {
                if (success.data.is_newLike == 1) {
                    $('#post-like-' + post_id).addClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                } else if (success.data.is_oldLike == 1) {
                    $('#post-like-' + post_id).removeClass('like');
                    $('#post-like-count-' + post_id).html(success.data.likePost_count);
                    if (success.data.likePost_count == '0') {
                        $('#post-other-like-' + post_id).html('');
                    } else {
                        $('#post-other-like-' + post_id).html(success.data.post_like_data);
                    }
                }
            }
        });
    }

    $scope.sendComment = function (post_id, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        var comment = $('#commentTaxBox-' + post_id).html();
        //comment = comment.replace(/^(<br\s*\/?>)+/, '');
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentInsert',
                data: 'comment=' + comment + '&post_id=' + post_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .then(function (success) {
                        data = success.data;
                        if (data.message == '1') {
                            if (commentClassName == 'last-comment') {
                                $scope.postData[index].post_comment_data.splice(0, 1);
                                $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                                $('.post-comment-count-' + post_id).html(data.comment_count);
                                $('.editable_text').html('');
                            } else {
                                $scope.postData[index].post_comment_data.push(data.comment_data[0]);
                                $('.post-comment-count-' + post_id).html(data.comment_count);
                                $('.editable_text').html('');
                            }
                        }
                    });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }

    $scope.viewAllComment = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewAllComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    $scope.postData[index].post_comment_data = data.all_comment_data;
                });

    }

    $scope.viewLastComment = function (post_id, index, post) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/viewLastComment',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    $scope.postData[index].post_comment_data = data.comment_data;
                });

    }
    $scope.deletePostComment = function (comment_id, post_id, parent_index, index, post) {
        $scope.c_d_comment_id = comment_id;
        $scope.c_d_post_id = post_id;
        $scope.c_d_parent_index = parent_index;
        $scope.c_d_index = index;
        $scope.c_d_post = post;

        $('#delete_model').modal('show');
    }

    $scope.deleteComment = function (comment_id, post_id, parent_index, index, post) {
        var commentClassName = $('#comment-icon-' + post_id).attr('class').split(' ')[0];
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    if (commentClassName == 'last-comment') {
                        $scope.postData[parent_index].post_comment_data.splice(0, 1);
                        $scope.postData[parent_index].post_comment_data.push(data.comment_data[0]);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    } else {
                        $scope.postData[parent_index].post_comment_data.splice(index, 1);
                        $('.post-comment-count-' + post_id).html(data.comment_count);
                        $('.editable_text').html('');
                    }
                });
    }

    $scope.likePostComment = function (comment_id, post_id) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/likePostComment',
            data: 'comment_id=' + comment_id + '&post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    if (data.message == '1') {
                        if (data.is_newLike == 1) {
                            $('#post-comment-like-' + comment_id).parent('a').addClass('like');
                            $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                        } else if (data.is_oldLike == 1) {
                            $('#post-comment-like-' + comment_id).parent('a').removeClass('like');
                            $('#post-comment-like-' + comment_id).html(data.commentLikeCount);
                        }

                    }
                });
    }
    $scope.editPostComment = function (comment_id, post_id, parent_index, index) {
        var editContent = $('#comment-dis-inner-' + comment_id).html();
        $('#edit-comment-' + comment_id).show();
        $('#editCommentTaxBox-' + comment_id).html(editContent);
        $('#comment-dis-inner-' + comment_id).hide();
    }

    $scope.EditPost = function (post_id, post_for, index) {
        $scope.is_edit = 1;


        $http({
            method: 'POST',
            url: base_url + 'user_post/getPostData',
            data: 'post_id=' + post_id + '&post_for=' + post_for,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    $scope.is_edit = 1;
                    if (post_for == "opportunity") {
                        $scope.opp.description = success.data.opportunity;
                        $scope.opp.job_title = success.data.opportunity_for;
                        $scope.opp.location = success.data.location;
                        $scope.opp.field = success.data.field;
                        $scope.opp.edit_post_id = post_id;
                        $("#opportunity-popup").modal('show');

                    } else if (post_for == "simple") {
                        $scope.sim.description = success.data.description;
                        $scope.sim.edit_post_id = post_id;

                        $("#post-popup").modal('show');

                    } else if (post_for == "question") {
                        $scope.ask.ask_que = success.data.question;
                        $scope.ask.ask_description = success.data.description;
                        $scope.ask.related_category = success.data.tag_name;
                        $scope.ask.ask_field = success.data.field;
                        $scope.ask.edit_post_id = post_id;

                        $("#ask-question").modal('show');
                    }
                });


    }

    $scope.sendEditComment = function (comment_id) {
        var comment = $('#editCommentTaxBox-' + comment_id).html();
        comment = comment.replace(/&nbsp;/gi, " ");
        comment = comment.replace(/<br>$/, '');
        comment = comment.replace(/&gt;/gi, ">");
        comment = comment.replace(/&/g, "%26");
        if (comment) {
            $scope.isMsg = true;
            $http({
                method: 'POST',
                url: base_url + 'user_post/postCommentUpdate',
                data: 'comment=' + comment + '&comment_id=' + comment_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .then(function (success) {
                        data = success.data;
                        if (data.message == '1') {
                            $('#comment-dis-inner-' + comment_id).show();
                            $('#comment-dis-inner-' + comment_id).html(comment);
                            $('#edit-comment-' + comment_id).html();
                            $('#edit-comment-' + comment_id).hide();
                        }
                    });
        } else {
            $scope.isMsgBoxEmpty = true;
        }
    }
    $scope.deletePost = function (post_id, index) {
        $scope.p_d_post_id = post_id;
        $scope.p_d_index = index;

        $('#delete_post_model').modal('show');
    }
    $scope.deletedPost = function (post_id, index) {
        $http({
            method: 'POST',
            url: base_url + 'user_post/deletePost',
            data: 'post_id=' + post_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(function (success) {
                    data = success.data;
                    if (data.message == '1') {
                        $scope.postData.splice(index, 1);
                    }
                });
    }
});

$(window).on("load", function () {
    $(".custom-scroll").mCustomScrollbar({
        autoHideScrollbar: true,
        theme: "minimal"
    });
});