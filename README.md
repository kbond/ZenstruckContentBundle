# Installation

Add routing to your ``routing.yml``:

    zenstruck_content:
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

        zenstruck_content:
            content_types:
                blog_post: YourApplicationBundle\Entity\BlogPost

    **Note:** in the above example the *machine name* of class ``BlogPost`` is ``blog_post``.
    This naming convention is important.

3. To use the controller that this bundle provides activate it in your ``config.yml``:

        zenstruck_content:
            use_controller: true

4. To provide your own templates set the ``default_template`` option in your ``config.yml``:

        zenstruck_content:
            default_template: YourApplicationBundle:Content:node.html.twig

    **Note:** the default template name must be ``node``.

# Reference

Override ``Node`` base class:

    zenstruck_content:
        node_class:  Your\Node\Class

## Full Default Configuration

    zenstruck_content:
        use_controller: false
        use_form: false
        default_template: ZenstruckContentBundle:Node:node.html.twig
        node_class:  Zenstruck\Bundle\ContentBundle\Entity\Node
        content_types: {}

# TODO

* Advanced implementation using nested set extension



