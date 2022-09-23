function validaNumLetras(event)
{
    //A65	Z90	a97	z122
    if((event.charCode >= 65 && event.charCode <= 90)  ||
        (event.charCode >= 97 && event.charCode <= 122) ||
        (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 209 || event.charCode == 241 )
    {
        return true;
    }else return false;
}

function validaLetrasOtro(event)
{
    //A65	Z90	a97	z122 Ã±Ã‘ Ã©
    if(event.keyCode != 8 && event.keyCode != 46 && event.keyCode != 9 && event.keyCode != 32) //&& event.keyCode != 37 && event.keyCode != 39)
    {
        if((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 130 ||
            (event.charCode >= 160 && event.charCode <= 165) || event.charCode == 188 || event.charCode == 190
            || event.charCode == 209 || event.charCode == 241 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205
            || event.charCode == 211 || event.charCode == 218 || event.charCode == 225 || event.charCode == 233 || event.charCode == 237
            || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 45 || event.charCode == 46)
        {
            return true;
        }else return false;
    }else return true;
}

function validaNumericos(event)
{
    if(event.keyCode != 8 && event.keyCode != 46 && event.keyCode != 9) // && event.keyCode != 37 && event.keyCode != 39)
    {
        if(event.charCode >= 48 && event.charCode <= 57)
        {
            return true;
        }
        else return false;
    }else return true;
}