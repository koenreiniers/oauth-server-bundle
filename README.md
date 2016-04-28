# Installation

## Add to routing.yml:

kr_oauth_server:
    resource: "@KrOAuthServerBundle/Controller"
    type: annotation
    
## Add to config.yml:

kr_oauth_server:
    classmap:
        access_token:       AcmeBundle\Entity\AccessToken
        refresh_token:      AcmeBundle\Entity\RefreshToken
        client:             AcmeBundle\Entity\Client
        authorization_code: AcmeBundle\Entity\AuthorizationCode
        
## Add to security.yml:

        oauth_token:
            pattern:          ^/oauth/token
            stateless:        true
            grant_request:    true

        oauth_auth:
            pattern:          ^/oauth/auth
            form_login:
                provider:               fos_userbundle
                csrf_token_generator:   security.csrf.token_manager
                check_path:             /oauth/auth/login_check
            logout:       true
            anonymous:    true

        oauth_resource:
            pattern:      ^/api/v1
            stateless:    true
            oauth:        true