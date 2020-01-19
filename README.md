OAuth2 Authorization Server

To get authorization code grant, send a GET request to /oauth2/authorize, with the following query parameters:

response_type = code.
'client_id' with the client identifer.
'redirect_uri' with the URI to which to redirect the client following successful authorization. This parameter is optional, but if it is not sent, the user will be redirected to a default location on completion.
'scope' with a space-delimited list of requested scope permissions.
'state' with a Cross-Site Request Forgery (CSRF) token. This parameter is optional, but highly recommended. You can store the value of the CSRF token in the user’s session to be validated in the next step.
'code_challenge' following the specifications of RFC-7636 

To receive access token with the authorization code, send a POST request to /oauth2/token, containing the following 

grant_type = authorization_code.
'client_id' with the client’s ID.
'client_secret' with the client’s secret.
'redirect_uri' with the previous client redirect URI.
'code' with the authorization code as returned in the authorization code request (as detailed in the previous section).
'code_verifier' the same as teh code_challenge, sent to the authorization server previously

To get the cliend credentials grant, send a POST request to /oauth2/token, with the following parameters:

grant_type = client_credentials.
'client_id' with the client's ID.
'client_secret' with the client's secret.
'scope' with a space-delimited list of requested scope permissions.

To get a password grant, send a POST request to /oauth2/token, with the following parameters:

grant_type = password.
'client_id' with the client’s ID.
'client_secret' with the client’s secret.
'scope' with a space-delimited list of requested scope permissions.
'username' with the user’s username.
'password' with the user’s password.
