function validBracketSequence() {
  $sequence = "[]";
  $long_str   = strlen($sequence);
  $first_str  = substr($sequence,1,1);
  $last_str   = substr($sequence,$long_str,1);
  if($first_str=='(' && $last_str==')')
  {
      print "the secuence is  true";
      return true;
  }
  else
  {
    if($first_str=='[' && $last_str==']')
    {
      print "the secuence is true";
      return true;
    } 
    else
    if($first_str=='{' && $last_str=='}')
    {
      print "the secuence is true";
      return true;
    }
    else
    {
        print "the secuence is false";
        return false;
    }
  }


  
}
