/**
 * Created by john one on 16.10.2018.
 */
var param = $('meta[name=csrf-param]').attr("content");
var token = $('meta[name=csrf-token]').attr("content");
export default {param, token}