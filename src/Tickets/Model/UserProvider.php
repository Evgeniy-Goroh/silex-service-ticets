<?php
namespace Model
{
    use Symfony\Component\Security\Core\User\UserProviderInterface;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\Security\Core\User\User;
    use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
    use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
    
    /**
     * provide users to the security service
     */
    class UserProvider extends BaseModel implements UserProviderInterface
    {
        
        
        public function loadUserByUsername($username)
        {
            $email = strtolower( $username);
            $sql = "SELECT `mail`, `password`,`role` FROM `users` WHERE mail = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($email));
            
            if ( !$user = $stmt->fetch()) {
                throw new UsernameNotFoundException( sprintf( 'Username "%s" does not exist.', $email ) );
            }
            
            $obUser = new User(
                    $user['mail'],
                    $user['password'],
                    explode(',', $user['role']),
                    true,
                    true,
                    true,
                    true );
            
            return $obUser;
        }
        
        public function refreshUser( UserInterface $user )
        {
            if ( !$user instanceof User ) {
                throw new UnsupportedUserException( sprintf('Instance of "%s" are not supported'), get_class( $user ) );
            }
            
            return $this->loadUserByUsername( $user->getUsername() );
        }
        
        public function supportsClass($class)
        {
            
            return $class === 'Symfony\Component\Security\Core\User\User';
        }
        
    }
}