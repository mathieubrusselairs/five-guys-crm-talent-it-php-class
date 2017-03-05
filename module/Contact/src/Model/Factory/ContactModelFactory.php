<?php

namespace Contact\Model\Factory;


use Contact\Entity\Contact;
use Contact\Entity\Factory\ContactHydratorFactory;
use Contact\Model\ContactModel;
use Contact\Model\EmailAddressModel;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContactModelFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $emailAddressModel = $container->get(EmailAddressModel::class);
        $contactHydratorFactory = new ContactHydratorFactory();
        $contactHydrator = $contactHydratorFactory->prepareHydrator($emailAddressModel);

        return new ContactModel(
            $container->get(AdapterInterface::class),
            $contactHydrator,
            new Contact()
        );
    }

}