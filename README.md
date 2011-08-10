# Installation

Add routing to your ``routing.yml``:

    CMS:
        resource: "@ZenstruckContentBundle/Resources/config/routing.yml"

# Configuration

1. Create a new content-type Entity:
    
        // path/to/your/bundle/Entity/BlogPost.php

        namespace YourApplicationBundle\Entity;

        use Zenstruck\Bundle\ContentBundle\Entity\Node;

        /**
         * @orm:Entity
         */
        class BlogPost extends Node
        {
            /**
             * @orm:Column(type="text", nullable=true)
             */  
            protected $body;

            public function getBody()     
            {
                return $this->body;
            }

            public function setBody($body)
            {
                $this->body = $body;
            }
        }

2. Add new content-type to your ``config.yml``:

        zenstruck_cms:
            content_types:
                blog_post: YourApplicationBundle\Entity\Page

3. Create twig template at ``app/Resources/ZenstruckContentBundle/views/CMS/blog_post.twig.html``

**Note:** in the above example the *machine name* of class ``BlogPost`` is ``blog_post``.
This naming convention is important.

# Reference

Override ``Node`` base class:

    zenstruck_cms:
        node_class:  Your\Node\Class


