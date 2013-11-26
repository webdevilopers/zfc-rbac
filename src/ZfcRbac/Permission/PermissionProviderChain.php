<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfcRbac\Permission;

use ZfcRbac\Service\RbacEvent;

/**
 * Simple implementation for a permission provider chain
 */
class PermissionProviderChain implements PermissionProviderInterface
{
    /**
     * List of permission providers
     *
     * @var PermissionProviderInterface[]
     */
    private $permissionProviders;

    /**
     * Constructor
     *
     * @param PermissionProviderInterface[] $permissionProviders
     */
    public function __construct(array $permissionProviders = [])
    {
        $this->permissionProviders = $permissionProviders;
    }

    /**
     * Add a permission provider in the chain
     *
     * @param  PermissionProviderInterface $permissionProvider
     * @return void
     */
    public function addPermissionProvider(PermissionProviderInterface $permissionProvider)
    {
        $this->permissionProviders[] = $permissionProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function getPermissions(RbacEvent $event)
    {
        $permissions = [];

        foreach ($this->permissionProviders as $permissionProvider) {
            $permissions = array_merge_recursive($permissions, $permissionProvider->getPermissions($event));
        }

        return $permissions;
    }
}
