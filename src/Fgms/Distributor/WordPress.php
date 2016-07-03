<?php
namespace Fgms\Distributor;

/**
 *  An interface which allows for WordPress itself to be mocked
 *  and substituted.
 */
interface WordPress
{
    /**
     *  Dispatches a WordPress builtin function.
     *
     *  This method allows any WordPress function to be called
     *  as if it were a member of an instance of a class which
     *  implements this interface.
     *
     *  \param [in] $name
     *      The name of the WordPress builtin function to call.
     *  \param [in] $args
     *      The arguments to pass to the WordPress builtin function
     *      specified by \em name.
     *
     *  \return
     *      Whatever the builtin function specified by \em name
     *      returns when called with \em args.
     */
    public function __call($name, array $args);
}