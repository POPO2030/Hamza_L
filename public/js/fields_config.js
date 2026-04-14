    // replace arabic letter
    function replaceChars(element) {
        var text = element.value;
        // text = text.replace(/ة/g, 'ه');
        // text = text.replace(/ى/g, 'ي');
        text = text.replace(/إ|آ|أ/g, 'ا');
        element.value = text;
    }
    