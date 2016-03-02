<?php

namespace Vain\Packages\Menu\Matcher;

use Illuminate\Http\Request;
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;

/**
 * Voter based on the route.
 */
class RouteVoter implements VoterInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function matchItem(ItemInterface $item)
    {
        if (null === $this->request) {
            return;
        }

        if (null === $route = $this->request->route()) {
            return;
        }

        $routes = $item->getExtra('routes', []);
        foreach ($routes as $probe) {
            if ($probe === $route->getName()) {
                return true;
            }
        }

        $patterns = $item->getExtra('patterns', []);
        foreach ($patterns as $pattern) {
            if ($pattern && preg_match($pattern, $route->getName())) {
                return true;
            }
        }
    }
}
