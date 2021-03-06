<?php

namespace spec\Purist\Endpoint;

use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Endpoint\Endpoint;

class MatchingEndpointSpec extends ObjectBehavior
{
    function let(
        RequestInterface $request,
        ResponseInterface $response,
        Endpoint $endpoint1,
        Endpoint $endpoint2
    )
    {
        $endpoint1->response($request)->willReturn($response);
        $endpoint2->response($request)->willReturn($response);

        $this->beConstructedWith($endpoint1, $endpoint2);
    }

    function it_can_return_a_response($request, $response, $endpoint1, $endpoint2)
    {
        $endpoint1->match($request)->willReturn(true);
        $endpoint2->match($request)->willReturn(false);

        $this->response($request)->shouldReturn($response);
    }

    function it_will_match_if_an_endpoint_does($request, $endpoint1, $endpoint2) {
        $endpoint1->match($request)->willReturn(true);
        $endpoint2->match($request)->willReturn(false);

        $this->match($request)->shouldReturn(true);
    }

    function it_will_not_match_if_endpoints_does_not($request, $endpoint1, $endpoint2) {
        $endpoint1->match($request)->willReturn(false);
        $endpoint2->match($request)->willReturn(false);

        $this->match($request)->shouldReturn(false);
    }

    function it_throws_exception_if_no_endpoint_matches_request($request, $endpoint1, $endpoint2)
    {
        $endpoint1->match($request)->willReturn(false);
        $endpoint2->match($request)->willReturn(false);

        $this->shouldThrow('Exception')->duringResponse($request);
    }
}
