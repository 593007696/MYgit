
    function changeImage()
    {
        element=document.getElementById('myimage')
            if (element.src.match("dog2"))
            {
                element.src="image/dog1.png";
            }
            else
            {
                element.src="image/dog2.png";
            }
    }

