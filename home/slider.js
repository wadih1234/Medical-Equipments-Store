var slidenumber=2;
    $(document).ready(function(){
        $("#s1").show();
        $(".c1").css("background-color","lightgrey");
        $(".c1").click(function(){
            $("#s1").show();
            $("#s2").hide();
            $("#s3").hide();
            $(this).css("background-color","lightgrey");
            $(".c2").css("background-color","white");
            $(".c3").css("background-color","white");
        });
        $(".c2").click(function(){
            $("#s2").show();
            $("#s1").hide();
            $("#s3").hide();
            $(this).css("background-color","lightgrey");
            $(".c1").css("background-color","white");
            $(".c3").css("background-color","white");
        });
        $(".c3").click(function(){
            $("#s3").show();
            $("#s1").hide();
            $("#s2").hide();
            $(this).css("background-color","lightgrey");
            $(".c1").css("background-color","white");
            $(".c2").css("background-color","white");
        });
        setInterval(() => {
            changeSlide(slidenumber++);
        },4000);

        function changeSlide(number){
            if(number==1){
                $("#s1").show();
            $("#s2").hide();
            $("#s3").hide();
            $(".c1").css("background-color","lightgrey");
            $(".c2").css("background-color","white");
            $(".c3").css("background-color","white");
            }
            else if(number==2){
                $("#s2").show();
            $("#s1").hide();
            $("#s3").hide();
            $(".c2").css("background-color","lightgrey");
            $(".c1").css("background-color","white");
            $(".c3").css("background-color","white");
            }
            else if(number==3){
                $("#s3").show();
            $("#s1").hide();
            $("#s2").hide();
            $(".c3").css("background-color","lightgrey");
            $(".c1").css("background-color","white");
            $(".c2").css("background-color","white");
            slidenumber=1; 
            }
        }

    }
    );