<?php

namespace Zenstruck\Bundle\ContentBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\App\Bundle\Entity\Page;
use Zenstruck\Bundle\ContentBundle\Tests\Fixtures\App\Bundle\Entity\BlogPost;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class ApplicationTest extends WebTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    public function testHomepage()
    {
        $client = $this->prepareEnvironment();

        $crawler = $client->request('GET', '/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h1:contains("Homepage")')->count() > 0);
        $this->assertTrue($crawler->filter('h2:contains("page")')->count() > 0);
    }

    public function testPage()
    {
        $client = $this->prepareEnvironment();

        $crawler = $client->request('GET', '/foo');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h1:contains("Page 1")')->count());
        $this->assertEquals(1, $crawler->filter('h2:contains("page")')->count());
    }

    public function testBreadcrumbs()
    {
        $client = $this->prepareEnvironment();

        $crawler = $client->request('GET', '/foo/bar/baz/bam');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h1:contains("Page 3")')->count() > 0);
        $this->assertTrue($crawler->filter('#breadcrumbs a')->count() > 1);
    }

    public function testBlogPost()
    {
        $client = $this->prepareEnvironment();

        $crawler = $client->request('GET', '/foo/bar');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h1:contains("Post 1")')->count() > 0);
        $this->assertTrue($crawler->filter('h2:contains("blog_post")')->count() > 0);
        $this->assertTrue($crawler->filter('h3:contains("symfony, php")')->count() > 0);
        $this->assertTrue($crawler->filter('p:contains("body")')->count() > 0);
        $this->assertTrue($crawler->filter('#breadcrumbs a')->count() > 0);
    }

    public function testSitemap()
    {
        $client = $this->prepareEnvironment();
        $today = new \DateTime();
        $today = $today->format('Y-m-d');

        $crawler = $client->request('GET', '/sitemap.xml');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $this->assertEquals(4, $crawler->filter('url')->count());
        $this->assertTrue($crawler->filter('loc:contains("http://localhost/foo/bar/baz/bam")')->count() > 0);
        $this->assertTrue($crawler->filter('lastmod:contains("'.$today.'")')->count() > 0);
    }

    protected function prepareEnvironment()
    {
        $client = parent::createClient();

        $application = new Application($client->getKernel());
        $application->setAutoExit(false);
        $this->runConsole($application, "doctrine:database:drop", array("--force" => true));
        $this->runConsole($application, "doctrine:database:create");
        $this->runConsole($application, "doctrine:schema:create");

        $this->em = $client->getContainer()->get('doctrine')->getManager();
        $this->addTestData();

        return $client;
    }

    protected function runConsole(Application $application, $command, array $options = array())
    {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    protected function addTestData()
    {
        // empty db
        $this->em->createQuery('DELETE ContentTestBundle:Page')
            ->execute()
        ;

        $page1 = new Page();
        $page1->setTitle('Page 1');
        $page1->setPath('/foo');
        $page1->setBody('Page 1 body');

        $page2 = new Page();
        $page2->setTitle('Homepage');
        $page2->setPath('<front>');

        $post1 = new BlogPost();
        $post1->setTitle('Post 1');
        $post1->setPath('/foo/bar');
        $post1->setBody('Post 1 body');
        $post1->setTags('symfony, php');

        $page3 = new Page();
        $page3->setTitle('Page 3');
        $page3->setPath('/foo/bar/baz/bam');

        $this->em->persist($page1);
        $this->em->persist($page2);
        $this->em->persist($page3);
        $this->em->persist($post1);

        $this->em->flush();
    }
}
