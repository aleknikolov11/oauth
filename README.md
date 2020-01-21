#OAuth2 Authorization Server#

The application uses the oauth2 package provided in:
https://docs.zendframework.com/zend-expressive-authentication-oauth2/

The following grants are supported:

	* Authorization Code Grant
	* Client Credentials Grant
	* Password Grant

##Configuration##

To configure the authorization server, the .dist extension of auth.local.php.dist file, located in ./config/autoload, should be removed. In this file, the 'pdo' section should be filled to configure the  database, used for the server:

``` 
'pdo' => [
            'dsn'      => '',
            'username' => '',
            'password' => '',
            'table' => '',
            'field' => [
                'identity' => '',
                'password' => '',
            ],
        ],
```
	* 'dsn', 'username' and 'password' are used for the PDO database configuration
	* 'table' - the name of the table, containing the users information(username and password)
	* 'identity' - the name of the column from the table that contains the usernames
	* 'password' - the name of the column from the table that contains user password
	
A sample database is provided in ./data (oauth.sql). It conatins the following tables:
	
	* oauth_users
	* oauth_clients
	* oauth_scopes
	* oauth_auth_codes
	* oauth_access_tokens
	* oauth_refresh_tokens
	
The database also contains entries in the following tables:
	
	*oauth_users - user with username=test_user and password=test123
	*oauth_scopes - read and write
	*oauth_clients - client with name=client_name and secret=secret
	
##Grants##

###Authorization Code Grant###

The client sends the following parameters via query string arguments to the authorization server(oauth2/authorize):

	* response_type = code.
	* 'client_id' - the client identifer.
	* 'redirect_uri' - the URI to which to redirect the client following successful authorization. This parameter is optional, but if it is not sent, the user will be redirected to a default location on completion.
	* 'scope' - a space-delimited list of requested scope permissions.
	* 'state' - a Cross-Site Request Forgery (CSRF) token. This parameter is optional, but highly recommended. You can store the value of the CSRF token in the user’s session to be validated in the next step.
	* 'code_challenge' - following the specifications of RFC-7636
	
The user will then be asked to login to the authorization server and approve the client request. If the user approves the request they will be redirected to the redirect URI with the following parameters in the query string arguments:

	* code - the authorization code.
	* state - the CSRF parameter sent in the original request. You can compare this value with the one stored in the user’s session.
	
**Example**

```curl "localhost:8080/oauth2/authorize?response_type=code&client_id=client_name&redirect_uri=%2F&scope=read&code_challenge=47DEQpj8HBSaKL4TImWF5JCeuQeRkm5NMpJWZG3hSuFU"```

**Access Token**

To request the access token, the client sends a POST request to the authorization server (oauth2/token) with the following parameters:

	* grant_type = authorization_code.
	* 'client_id' - the client’s ID.
	* 'client_secret' - the client’s secret.
	* 'redirect_uri' - the previous client redirect URI.
	* 'code' - the authorization code as returned in the authorization code request (as detailed in the previous section).
	
The authorization server responds sends a JSON payload with values as follows:

	* 'token_type' - the type of generated token (here, and generally, "Bearer").
	* 'expires_in' - an integer representing the time-to-live (in seconds) of the access token.
	* 'refresh_token' - a token that can be used to refresh the access_token when expired.
	* 'access_token' - a JSON Web Token (JWT) signed with the authorization server’s private key. This token must be used in the Authorization request HTTP header on subsequent requests.
	
**Example**

```curl --data="grant_type=authorization_code&client_id=client_name&client_secret=secret&redirect_uri=%2F&code=code_received_from_server" localhost:8080/oauth2/token```

###Client Credentials Grant###

The client sends a POST request with the following body parameters to the authorization server	(oauth2/token):

	* grant_type = client_credentials.
	* 'client_id' - the client's ID.
	* 'client_secret' - the client's secret.
	* 'scope' - a space-delimited list of requested scope permissions.
	
The values returned are as follows:

	* 'token_type' - the type of generated token (here, and generally, Bearer).
	* 'expires_in' - an integer representing the time-to-live (in seconds) of the access token.
	* 'access_token' - a JSON Web Token (JWT) signed with the authorization server’s private key. This token must be used in the Authorization request HTTP header in subsequent requests.
	
**Example**

```curl --data="grant_type=client_credentials&client_id=client_name&client_secret=secret&scope=read" localhost:8080/oauth2/token```

###Password Grant###

The client sends a POST request with following parameters to the authorization server (oauth2/token):

	* grant_type = password.
	* 'client_id' - the client’s ID.
	* 'client_secret' - the client’s secret.
	* 'scope' - a space-delimited list of requested scope permissions.
	* 'username' - the user’s username.
	* 'password' - the user’s password.
	
The authorization server responds with a JSON as follows:

	* 'token_type'  the type of generated token (Bearer).
	* 'expires_in' - an integer representing the TTL (in seconds) of the access token.
	* 'refresh_token' - a token that can be used to refresh the access_token when expired.
	* 'access_token' - a JWT signed with the authorization server’s private key. This token must be used in the Authorization request HTTP header.
	
**Example**

```curl --data="grant_type=password&client_id=client_name&client_secret=secret&scope=read&username=test_user&password=test123" localhost:8080/oauth2/token```