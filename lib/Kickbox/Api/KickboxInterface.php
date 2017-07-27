<?php

namespace Kickbox\Api;

use Kickbox\HttpClient\Response;

interface KickboxInterface
{
    /**
     * @param $email
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function verify($email, array $options = []);

    /**
     * @method verifyBatch
     * @param  array $emails
     * @param  array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function verifyBatch($emails, array $options = []);

    /**
     * @param integer $id
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function getBatchResults($id, array $options = []);


    /**
     * @param string $email
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function isDisposable($email, array $options = []);

    /**
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function getCreditBalance(array $options = []);
}
